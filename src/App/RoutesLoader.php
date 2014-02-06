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
        $this->app['users.controller'] = $this->app->share(
            function () {
                return new Controllers\UsersController($this->app['users.service']);
            }
        );
        $this->app['nodes.controller'] = $this->app->share(
            function () {
                return new Controllers\NodesController($this->app['nodes.service']);
            }
        );
    }

    public function bindRoutesToControllers()
    {
        $api = $this->app['controllers_factory'];

        $api->get('/users', 'users.controller:getAll');
        $api->post('/users', 'users.controller:save');
        $api->put('/users/{id}', 'users.controller:update');
        $api->delete('/users/{id}', 'users.controller:delete');

        $api->get('/clusters', 'clusters.controller:getAll');
        $api->post('/clusters', 'clusters.controller:save');
        $api->put('/clusters/{id}', 'clusters.controller:update');
        $api->delete('/clusters/{id}', 'clusters.controller:delete');

        $api->get('/clusters/{id}/instances', 'instances.controller:getAll');
        $api->post('/clusters/{id}/instances', 'instances.controller:save');
        $api->get('/clusters/{id}/instances/{instance_id}', 'instances.controller:get');

        $api->get('/nodes', 'nodes.controller:getAll');
        $api->post('/nodes', 'nodes.controller:save');
        $api->put('/nodes/{id}', 'nodes.controller:update');
        $api->delete('/nodes/{id}', 'nodes.controller:delete');

        $api->get('/apps', 'apps.controller:getAll');
        $api->post('/apps', 'apps.controller:save');
        $api->put('/apps/{id}', 'apps.controller:update');
        $api->delete('/apps/{id}', 'apps.controller:delete');
        $api->post('/apps/{id}/connect/{instance_id}', 'apps.controller:connect');
        $api->post('/apps/{id}/deploy/{instance_id}', 'apps.controller:deploy');

        $this->app->mount($this->app['api.endpoint'] . '/' . $this->app['api.version'], $api);
    }
}
