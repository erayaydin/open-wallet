<?php

namespace OpenWallet\Providers;

use Illuminate\Support\ServiceProvider;
use OpenWallet\Api\Providers\ApiServiceProvider;

class OpenWalletServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(ApiServiceProvider::class);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom($this->app->basePath('src/Database/Migrations'));
    }
}
