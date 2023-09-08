<?php

namespace OpenWallet\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    /** @var Application */
    protected $app;

    public function register(): void
    {
        $this->booted(function () {
            if ($this->app->routesAreCached()) {
                $this->app->booted(function () {
                    require $this->app->getCachedRoutesPath();
                });

                return;
            }

            $this->loadRoutes();

            $this->app->booted(function () {
                /** @var Router */
                $router = $this->app['router'];

                $router->getRoutes()->refreshNameLookups();
                $router->getRoutes()->refreshActionLookups();
            });
        });
    }

    public function loadRoutes(): void
    {
        /** @var Router */
        $router = $this->app['router'];

        $router->prefix('api/v1')
            ->group(function (Router $router) {
                $router->get('/', function () {
                    return response()->noContent();
                });
            });
    }
}
