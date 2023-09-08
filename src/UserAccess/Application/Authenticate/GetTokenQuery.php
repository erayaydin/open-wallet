<?php

namespace OpenWallet\UserAccess\Application\Authenticate;

use OpenWallet\Shared\Domain\Bus\Query\Query;

final readonly class GetTokenQuery implements Query
{
    public function __construct(
        protected string $email,
        protected string $password,
        protected string $deviceName
    ) {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getDeviceName(): string
    {
        return $this->deviceName;
    }
}
