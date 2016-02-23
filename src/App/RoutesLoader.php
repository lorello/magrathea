<?php

namespace App;

use Silex\Application;

class RoutesLoader
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->instantiateControllers();
    }

    private function instantiateControllers()
    {
        $this->app['apps.controller'] = $this->app->share(
            function () {
                return new Controllers\AppsController($this->app['apps.service'], $this->app['security']);
            }
        );
        $this->app['instances.controller'] = $this->app->share(
            function () {
                return new Controllers\AppsController($this->app['instances.service'], $this->app['security']);
            }
        );
        $this->app['clusters.controller'] = $this->app->share(
            function () {
                return new Controllers\ClustersController($this->app['clusters.service'], $this->app['security']);
            }
        );
        $this->app['nodes.controller'] = $this->app->share(
            function () {
                return new Controllers\NodesController($this->app['nodes.service'], $this->app['security']);
            }
        );
        $this->app['users.controller'] = $this->app->share(
            function () {
                return new Controllers\UsersController($this->app['users.service'], $this->app['security']);
            }
        );
    }

    public function bindRoutesToControllers()
    {
        $api = $this->app['controllers_factory'];

        $api->get('/apps', 'apps.controller:getAll');
        $api->post('/apps', 'apps.controller:save');
        $api->put('/apps/{id}', 'apps.controller:update');
        $api->delete('/apps/{id}', 'apps.controller:delete');
        $api->post('/apps/{id}/connect/{instance_id}', 'apps.controller:connect');
        $api->post('/apps/{id}/deploy/{instance_id}', 'apps.controller:deploy');
        //$api->post('/apps/{id}/share/{email}', 'apps.controller:connect');

        $api->get('/clusters', 'clusters.controller:getAll');
        $api->post('/clusters', 'clusters.controller:save');
        $api->get('/clusters/{id}', 'clusters.controller:get');
        $api->put('/clusters/{id}', 'clusters.controller:update');
        $api->delete('/clusters/{id}', 'clusters.controller:delete');

        $api->get('/clusters/{id}/instances', 'instances.controller:getAll');
        $api->post('/clusters/{id}/instances', 'instances.controller:save');
        $api->get('/clusters/{id}/instances/{instance_id}', 'instances.controller:get');
        $api->delete('/clusters/{id}/instances/{instance_id}', 'instances.controller:delete');

        $api->put('/clusters/{cluster_id}/layer/{layer_name}/node/{node_id}', 'clusters.controller:addNode');
        //$api->put('/clusters/{name}/layers/sort', '');

        $api->get('/nodes', 'nodes.controller:getAll');
        $api->post('/nodes', 'nodes.controller:save');
        $api->put('/nodes/{id}', 'nodes.controller:update');
        $api->delete('/nodes/{id}', 'nodes.controller:delete');

        $api->get('/users', 'users.controller:getAll');
        $api->post('/users', 'users.controller:save');
        $api->put('/users/{id}', 'users.controller:update');
        $api->delete('/users/{id}', 'users.controller:delete');

        $api->post('/user/register', 'users.controller:register');
        $api->post('/user/activate/{activation_key}', 'users.controller:activate');

        $this->app->mount($this->app['api.endpoint'].'/'.$this->app['api.version'], $api);
    }
}
