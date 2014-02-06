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
        $this->app['users.service'] = $this->app->share(function () {
            return new Services\UsersService();
        });
        $this->app['nodes.service'] = $this->app->share(
            function () {
                return new Services\NodesService();
            }
        );
    }
}

