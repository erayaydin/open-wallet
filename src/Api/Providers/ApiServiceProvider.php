<?php

namespace OpenWallet\Api\Providers;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use OpenWallet\Api\Http\Controllers\Auth\AuthenticateController;
use OpenWallet\Api\Http\Controllers\Auth\AuthMeController;
use OpenWallet\Api\Http\Controllers\Auth\AuthRegisterController;
use OpenWallet\Api\Http\Controllers\StatusController;

class ApiServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->routesAreCached()) {
            $this->app->booted(function () {
                require $this->app->getCachedRoutesPath();
            });

            return;
        }

        $this->app->call([$this, 'loadRoutes']);

        $this->app->booted(function () {
            /** @var Router $app */
            $router = $this->app['router'];

            $router->getRoutes()->refreshNameLookups();
            $router->getRoutes()->refreshActionLookups();
        });
    }

    public function loadRoutes(Router $router): void
    {
        $router->middleware('api')
            ->prefix('api/v1')
            ->group(function (Router $router) {
                $router->get('/', StatusController::class);

                $router->as('auth.')
                    ->prefix('auth')
                    ->group(function (Router $router) {
                        $router->post('/', AuthenticateController::class)
                            ->name('get_token');

                        $router->get('me', AuthMeController::class)
                            ->middleware(Authenticate::using('sanctum'))
                            ->name('me');

                        $router->post('register', AuthRegisterController::class)
                            ->name('register');
                    });
            });
    }
}
