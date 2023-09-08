<?php

namespace OpenWallet\Shared\Infrastructure\Laravel\Traits;

use OpenWallet\Shared\Domain\UuidGenerator;

trait GeneratesUuid
{
    public function generateUuid(): string
    {
        return app(UuidGenerator::class)->generate();
    }
}
