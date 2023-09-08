<?php

namespace OpenWallet\Shared\Infrastructure\Laravel\Traits;

trait HasMigrations
{
    public function bootMigrations(): void
    {
        $this->loadMigrationsFrom($this->path('Infrastructure/Persistence/Migrations'));
    }
}
