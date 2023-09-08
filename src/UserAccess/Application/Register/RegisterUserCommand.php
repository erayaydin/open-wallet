<?php

namespace OpenWallet\UserAccess\Application\Register;

use OpenWallet\Shared\Domain\Bus\Command\Command;

final class RegisterUserCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $email,
        public readonly string $password
    ) {
    }
}
