<?php

namespace OpenWallet\Shared\Infrastructure\Bus\Exceptions;

use OpenWallet\Shared\Infrastructure\Exceptions\InfrastructureException;
use Throwable;

class CommandNotRegisteredException extends InfrastructureException
{
    public function __construct(string $message = 'Command not registered', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
