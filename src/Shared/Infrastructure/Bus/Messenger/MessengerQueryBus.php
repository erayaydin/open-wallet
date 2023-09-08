<?php

namespace OpenWallet\Shared\Infrastructure\Bus\Messenger;

use OpenWallet\Shared\Domain\Bus\Query\Query;
use OpenWallet\Shared\Domain\Bus\Query\QueryBus;
use OpenWallet\Shared\Domain\Bus\Query\Response;
use OpenWallet\Shared\Infrastructure\Bus\Exceptions\QueryNotRegisteredException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Symfony\Component\Messenger\Stamp\HandledStamp;

use function Lambdish\Phunctional\map;
use function Lambdish\Phunctional\reindex;

class MessengerQueryBus implements QueryBus
{
    private MessageBus $bus;

    public function __construct(iterable $queryHandlers)
    {
        $this->bus = new MessageBus(
            [
                new HandleMessageMiddleware(
                    new HandlersLocator(
                        map(
                            fn ($value) => [$value],
                            reindex(
                                fn (callable $handler): ?string => $this->extract($handler),
                                $queryHandlers
                            )
                        )
                    )
                ),
            ]
        );
    }

    /**
     * @throws QueryNotRegisteredException
     */
    public function ask(Query $query): ?Response
    {
        try {
            /** @var HandledStamp $stamp */
            $stamp = $this->bus->dispatch($query)->last(HandledStamp::class);

            return $stamp->getResult();
        } catch (NoHandlerForMessageException) {
            throw new QueryNotRegisteredException('Query '.get_class($query).' not registered.');
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
