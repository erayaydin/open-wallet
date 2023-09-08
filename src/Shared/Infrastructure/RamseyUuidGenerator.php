<?php

namespace OpenWallet\Shared\Infrastructure;

use OpenWallet\Shared\Domain\UuidGenerator;
use Ramsey\Uuid\Uuid;

class RamseyUuidGenerator implements UuidGenerator
{
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}
