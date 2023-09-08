<?php

namespace OpenWallet\UserAccess\Infrastructure\Laravel;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\RateLimiter;
use OpenWallet\Shared\Infrastructure\Laravel\DomainServiceProvider;
use OpenWallet\Shared\Infrastructure\Laravel\Traits\HasMigrations;
use OpenWallet\Shared\Infrastructure\Laravel\Traits\HasRoutes;
use OpenWallet\UserAccess\Application\Register\AccountRegisterCommandHandler;
use OpenWallet\UserAccess\Domain\Repository\UserRepository;
use OpenWallet\UserAccess\Infrastructure\Persistence\Eloquent\UserRepository as EloquentUserRepository;
use OpenWallet\UserAccess\Interface\Http\Controllers\AccountRegisterController;

final class UserAccessDomainServiceProvider extends DomainServiceProvider
{
    use HasMigrations, HasRoutes;

    protected array $repositories = [
        UserRepository::class => EloquentUserRepository::class,
    ];

    protected array $commandHandlers = [
        AccountRegisterCommandHandler::class,
    ];

    public function boot(): void
    {
        $this->bootRoutes($this->app);
        $this->bootMigrations();

        RateLimiter::for(
            'user_access',
            fn (Request $request) => Limit::perMinute(60)->by($request->user()?->id ?: $request->ip())
        );
    }

    public function loadRoutes(Router $router): void
    {
        $router
            ->as('api.account.')
            ->prefix('api/v1/account')
            ->group(function (Router $router) {
                $router
                    ->post('register', AccountRegisterController::class)
                    ->name('store');
            });
    }
}
