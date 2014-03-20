<?php

namespace App;

use Silex\Application;

class ServicesLoader
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function bindServicesIntoContainer()
    {
        $this->app['users.service']    = $this->app->share(
            function () {
                return new Services\UsersService();
            }
        );
        $this->app['apps.service']     = $this->app->share(
            function () {
                return new Services\AppsService($this->app['users.service']);
            }
        );
        $this->app['instances.service']     = $this->app->share(
            function () {
                return new Services\InstancesService($this->app['users.service']);
            }
        );
        $this->app['clusters.service'] = $this->app->share(
            function () {
                return new Services\ClustersService($this->app['users.service'], $this->app['instances.service'], $this->app['nodes.service']);
            }
        );
        $this->app['nodes.service']    = $this->app->share(
            function () {
                return new Services\NodesService($this->app['users.service']);
            }
        );
    }
}

