<?php

namespace OpenWallet\UserAccess\Domain\ValueObject;

use OpenWallet\Shared\Domain\ValueObject\SecretStringValueObject;

final class UserPassword extends SecretStringValueObject
{
    public function encrypted(): string
    {
        return bcrypt($this->getValue());
    }
}
