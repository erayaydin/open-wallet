<?php

namespace OpenWallet\UserAccess\Application\Register;

use OpenWallet\Shared\Domain\Bus\Command\Command;

final readonly class AccountRegisterCommand implements Command
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public string $password
    ) {
    }
}
