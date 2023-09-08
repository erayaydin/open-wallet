<?php

namespace OpenWallet\UserAccess\Application;

use OpenWallet\Shared\Domain\Bus\Query\Response;
use OpenWallet\UserAccess\Domain\Aggregate\User;

final class UserResponse implements Response
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $email
    ) {
    }

    public static function from(User $user): self
    {
        return new self(
            $user->id->getValue(),
            $user->name->getValue(),
            $user->email->getValue()
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}
