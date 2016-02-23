<?php

use Carbon\Carbon;
use Silex\Application;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\User;

date_default_timezone_set('Europe/Rome');
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', __DIR__.'/..');
}
if (!defined('MONGODM_CONFIG')) {
    define('MONGODM_CONFIG', ROOT_PATH.'/resources/config/mongodm.php');
}

$app->register(new ServiceControllerServiceProvider());

$app->register(
    new HttpCacheServiceProvider(),
    [
        'http_cache.cache_dir' => ROOT_PATH.'/storage/cache',
    ]
);

$app->register(
    new MonologServiceProvider(),
    [
        'monolog.logfile' => ROOT_PATH.'/storage/logs/'.Carbon::now('Europe/Rome')->format('Y-m-d').'.log',
        'monolog.level'   => $app['log.level'],
        'monolog.name'    => 'magrathea',
    ]
);

// http://silex.sensiolabs.org/doc/providers/security.html
// TODO: stop the redirect when accessing reserved area
$app->register(
    new Silex\Provider\SecurityServiceProvider(),
    [
        'security.firewalls' => [
            'test'    => [
                'pattern'   => '^/test/.*',
                'http'      => true,
                'security'  => true,
                'stateless' => true,
                'users'     => $app->share(
                    function () use ($app) {
                        return new App\UserProvider($app['users.service']);
                    }
                ),
            ],
            'user'    => [
                'anonymous' => true,
                'pattern'   => '^'.$app['api.endpoint'].'/'.$app['api.version'].'/user/(register|activate/[a-z0-9]+)$',
            ],
            'api' => [
                //'security'  => $app['debug'] ? false : true,
                'security'  => true,
                'pattern'   => '^'.$app['api.endpoint'].'/'.$app['api.version'],
                //'pattern'   => '^/.*',
                'http'      => true,
                'stateless' => true, // don't create cookie for http auth, it send credentials on each request
                'users'     => $app->share(
                    function () use ($app) {
                        return new App\UserProvider($app['users.service']);
                    }
                ),
            ],
            'default' => [
                'anonymous' => true,
                'pattern'   => '^/.*',
            ],
        ],
    ]
);
$app['security.role_hierarchy'] = [
    'ROLE_ADMIN' => ['ROLE_USER', 'ROLE_ALLOWED_TO_SWITCH'],
];

$app['security.access_rules'] = [
    ['^'.$app['api.endpoint'].'/'.$app['api.version'].'/users', 'ROLE_ADMIN'],
    ['^'.$app['api.endpoint'].'/'.$app['api.version'].'/nodes', 'ROLE_ADMIN'],
    ['^'.$app['api.endpoint'].'/'.$app['api.version'].'/clusters', 'ROLE_USER'],
    //array('^/api/v1/.*$', 'ROLE_USER'),
];

//handling CORS preflight request
$app->before(
    function (Request $request) {
        if ($request->getMethod() === 'OPTIONS') {
            $response = new Response();
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET,POST,PUT,DELETE,OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type');
            $response->setStatusCode(200);
            $response->send();
        }
    },
    Application::EARLY_EVENT
);

//handling CORS respons with right headers
$app->after(
    function (Request $request, Response $response) {
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET,POST,PUT,DELETE,OPTIONS');
    }
);

//accepting JSON
$app->before(
    function (Request $request) {
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : []);
        }
    }
);

$app->get(
    '/',
    function () use ($app) {
        //return new JsonResponse(array('message'=>'Magrathea is UP'));
        phpinfo();
    }
);

$app->match(
    '/test/security',
    function (Request $request) use ($app) {
        $result = '<h1>Test call</h1>';

        $token = $app['security']->getToken();

        if ($token === null) {
            $result .= 'Are you anon? Login please!';
        } else {
            $user = $token->getUser();
            $result .= 'Are you '.$user->getUsername()."?\n";
        }

        return $result;
    }
);

$app->get(
    '/test/mongo/add/{name}',
    function ($name) use ($app) {
        $user = new Documents\User();
        $user->name = $name;
        if ($user->save()) {
            return "Created $name";
        }

        return "Error  creating $name ".$user->getId();
    }
);

$app->get(
    '/test/mongo/users',
    function () use ($app) {
        $users = Documents\User::all();
        $s = '';
        foreach ($users as $u) {
            $s .= $u->getName().':'.$u->getPassword();
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

$app->error(
    function (\Exception $e, $code) use ($app) {
        $app['monolog']->addError($e->getMessage());
        $app['monolog']->addError($e->getTraceAsString());

        return new JsonResponse([
            'statusCode' => $code,
            'message'    => $e->getMessage(),
            'stacktrace' => $e->getTraceAsString(),
        ]);
    }
);

return $app;
