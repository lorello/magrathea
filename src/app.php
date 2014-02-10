<?php

use Silex\Application;
use Silex\Provider\HttpCacheServiceProvider;
use Neutron\Silex\Provider\MongoDBODMServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\ServicesLoader;
use App\RoutesLoader;
use Carbon\Carbon;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\User;

use Wildsurfer\Provider\MongodmServiceProvider;
use Purekid\Mongodm\MongoDB; 

date_default_timezone_set('Europe/Rome');

define("ROOT_PATH", __DIR__ . "/..");

$app->register(new ServiceControllerServiceProvider());

$app->register(new MongodmServiceProvider(), array(
    "mongodm.host"      => $app['mongodb.host'],
    "mongodm.db"        => $app['mongodb.db'],
    "mongodm.username"  => $app['mongodb.username'],
    "mongodm.password"  => $app['mongodb.password'],
    "mongodm.options"   => $app['mongodb.options']
));
$app->register(
    new HttpCacheServiceProvider(),
    array(
        "http_cache.cache_dir" => ROOT_PATH . "/storage/cache",
    )
);

$app->register(new MonologServiceProvider(), array(
    "monolog.logfile" => ROOT_PATH . "/storage/logs/" . Carbon::now('Europe/Rome')->format("Y-m-d") . ".log",
    "monolog.level" => $app["log.level"],
    "monolog.name" => "magrathea"
    ));

// http://silex.sensiolabs.org/doc/providers/security.html
$app->register(
    new Silex\Provider\SecurityServiceProvider(),
    array(
        'security.firewalls' => array(
            //'doc'   => array(
            //    'anonymous' => true,
            //    'pattern'   =>  '^/$app[api.endpoint]/$app[api.version]/doc',
            //),
            'default' => array(
                'security'  => $app['debug'] ? false : true,
                //'pattern'   => '^/$app[api.endpoint]/$app[api.version]',
                'pattern'   => '^/.*',
                'http'      => true,
                'stateless' => true, // don't create cookie for http auth, it send credentials on each request
                'users'     => $app->share(
                        function () use ($app) {
                            return new App\UserProvider($app['users.service']);
                        }
                    ),
            ),
        )
    )
);
$app['security.role_hierarchy'] = array(
    'ROLE_ADMIN' => array('ROLE_USER', 'ROLE_ALLOWED_TO_SWITCH'),
);

/*
 * $app['security.access_rules'] = array(
    array('^/admin', 'ROLE_ADMIN', 'https'),
    array('^.*$', 'ROLE_USER'),
);*/


//handling CORS preflight request
$app->before(
    function (Request $request) {
        if ($request->getMethod() === "OPTIONS") {
            $response = new Response();
            $response->headers->set("Access-Control-Allow-Origin", "*");
            $response->headers->set("Access-Control-Allow-Methods", "GET,POST,PUT,DELETE,OPTIONS");
            $response->headers->set("Access-Control-Allow-Headers", "Content-Type");
            $response->setStatusCode(200);
            $response->send();
        }
    },
    Application::EARLY_EVENT
);

//handling CORS respons with right headers
$app->after(
    function (Request $request, Response $response) {
        $response->headers->set("Access-Control-Allow-Origin", "*");
        $response->headers->set("Access-Control-Allow-Methods", "GET,POST,PUT,DELETE,OPTIONS");
    }
);

//accepting JSON
$app->before(
    function (Request $request) {
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : array());
        }
    }
);


$app->get(
    '/',
    function () use ($app) {
        return 'Magrathea is UP';
    }
);

$app->post(
    '/test',
    function(Request $request) use ($app) {
        $result = '';
        foreach ($request->request->all() as $key => $value) {
            $result .= $key . '=' . $value . '|';
        }

        return $result;
    }
);

$app->get(
    '/mongo/name/{name}',
    function ($name) use ($app) {
        $user = new Documents\User();
        $user->name = $name;
        $user->age = 10;
        if ($user->save())
          return "Created $name";
        return "Error  creating $name ".$user->getId();
    }
);

$app->get(
    '/mongo/users',
    function () use ($app) {
        $users = Documents\User::all();
        $s = '';
        foreach($users as $u)
        {
          $s .= $u->getName();
        }
        return $s;
    }
);

//load services
$servicesLoader = new App\ServicesLoader($app);
$servicesLoader->bindServicesIntoContainer();

//load routes
$routesLoader = new App\RoutesLoader($app);
$routesLoader->bindRoutesToControllers();

$app->error(function (\Exception $e, $code) use ($app) {
    $app['monolog']->addError($e->getMessage());
    $app['monolog']->addError($e->getTraceAsString());
    return new JsonResponse(array("statusCode" => $code, "message" => $e->getMessage(), "stacktrace" => $e->getTraceAsString()));
});

return $app;
