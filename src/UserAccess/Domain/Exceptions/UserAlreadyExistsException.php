<?php

namespace OpenWallet\UserAccess\Domain\Exceptions;

use OpenWallet\Shared\Domain\Exceptions\DomainException;
use Throwable;

class UserAlreadyExistsException extends DomainException
{
    public function __construct(string $message = 'User already exists', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
