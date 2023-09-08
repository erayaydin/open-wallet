<?php

namespace OpenWallet\Shared\Infrastructure\Laravel;

use Illuminate\Support\ServiceProvider;
use OpenWallet\Shared\Domain\UuidGenerator;
use OpenWallet\Shared\Infrastructure\RamseyUuidGenerator;

class RamseyUuidServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            UuidGenerator::class,
            RamseyUuidGenerator::class
        );
    }
}
