<?php

namespace OpenWallet\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(Application $app): void
    {
        $app->useAppPath($app->basePath('src'));
    }
}
