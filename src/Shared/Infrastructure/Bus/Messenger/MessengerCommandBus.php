<?php

namespace OpenWallet\Shared\Infrastructure\Bus\Messenger;

use OpenWallet\Shared\Domain\Bus\Command\Command;
use OpenWallet\Shared\Domain\Bus\Command\CommandBus;
use OpenWallet\Shared\Infrastructure\Bus\Exceptions\CommandNotRegisteredException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Throwable;

use function Lambdish\Phunctional\map;
use function Lambdish\Phunctional\reindex;

final class MessengerCommandBus implements CommandBus
{
    private MessageBus $bus;

    /**
     * @throws ReflectionException
     */
    public function __construct(iterable $commandHandlers)
    {
        $this->bus = new MessageBus(
            [
                new HandleMessageMiddleware(
                    new HandlersLocator(map(
                        fn ($value) => [$value],
                        reindex(
                            fn (callable $handler): ?string => $this->extract($handler),
                            $commandHandlers
                        )
                    ))
                ),
            ]
        );
    }

    /**
     * @throws Throwable
     * @throws CommandNotRegisteredException
     */
    public function dispatch(Command $command): void
    {
        try {
            $this->bus->dispatch($command);
        } catch (NoHandlerForMessageException) {
            throw new CommandNotRegisteredException('Command '.get_class($command).' not registered.');
        } catch (HandlerFailedException $error) {
            throw $error->getPrevious() ?? $error;
        }
    }

    /**
     * @throws ReflectionException
     */
    protected function extract($class): ?string
    {
        $reflector = new ReflectionClass($class);
        $method = $reflector->getMethod('__invoke');

        if ($this->hasOnlyOneParameter($method)) {
            return $this->firstParameterClassFrom($method);
        }

        return null;
    }

    private function hasOnlyOneParameter(ReflectionMethod $method): bool
    {
        return $method->getNumberOfParameters() === 1;
    }

    private function firstParameterClassFrom(ReflectionMethod $method): string
    {
        return $method->getParameters()[0]->getType()->getName();
    }
}
