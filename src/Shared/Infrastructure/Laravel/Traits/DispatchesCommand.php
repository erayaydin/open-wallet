<?php

namespace OpenWallet\Shared\Infrastructure\Laravel\Traits;

use OpenWallet\Shared\Domain\Bus\Command\Command;
use OpenWallet\Shared\Domain\Bus\Command\CommandBus;

trait DispatchesCommand
{
    public function dispatchCommand(Command $command): void
    {
        app(CommandBus::class)->dispatch($command);
    }
}
