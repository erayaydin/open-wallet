<?php

namespace OpenWallet\Shared\Infrastructure\Bus\Exceptions;

use OpenWallet\Shared\Infrastructure\Exceptions\InfrastructureException;
use Throwable;

class QueryNotRegisteredException extends InfrastructureException
{
    public function __construct(string $message = 'Query not registered', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
