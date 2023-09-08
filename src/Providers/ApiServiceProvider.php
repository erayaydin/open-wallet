<?php

namespace OpenWallet\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    public function boot(Application $app): void {
        if ($app->routesAreCached()) {
            $app->booted(function () use ($app) {
                require $app->getCachedRoutesPath();
            });

            return;
        }

        $app->call([$this, 'loadRoutes']);

        $app->booted(function (Application $app) {
            /** @var Router $app */
            $router = $app['router'];

            $router->getRoutes()->refreshNameLookups();
            $router->getRoutes()->refreshActionLookups();
        });
    }

    public function loadRoutes(Router $router): void
    {
        $router->prefix('api/v1')
            ->group(function (Router $router) {
                $router->get('/', function () {
                    return response()->noContent();
                });
            });
    }
}
