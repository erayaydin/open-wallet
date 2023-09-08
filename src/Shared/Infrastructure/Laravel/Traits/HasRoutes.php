<?php

namespace OpenWallet\Shared\Infrastructure\Laravel\Traits;

use Illuminate\Foundation\Application;
use Illuminate\Routing\Router;

trait HasRoutes
{
    public function bootRoutes(Application $app): void
    {
        if ($app->routesAreCached()) {
            $app->booted(function () use ($app) {
                require $app->getCachedRoutesPath();
            });
        } else {
            $app->call([$this, 'loadRoutes']);

            $app->booted(function () use ($app) {
                /** @var Router $router */
                $router = $app['router'];

                $router->getRoutes()->refreshNameLookups();
                $router->getRoutes()->refreshActionLookups();
            });
        }
    }

    public function loadRoutes(Router $router): void
    {
    }
}
