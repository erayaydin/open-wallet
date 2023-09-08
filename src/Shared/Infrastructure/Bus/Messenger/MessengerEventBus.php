<?php

namespace OpenWallet\Shared\Infrastructure\Bus\Messenger;

use OpenWallet\Shared\Domain\Bus\Event\DomainEvent;
use OpenWallet\Shared\Domain\Bus\Event\DomainEventSubscriber;
use OpenWallet\Shared\Domain\Bus\Event\EventBus;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

use function Lambdish\Phunctional\reduce;

final class MessengerEventBus implements EventBus
{
    private MessageBus $bus;

    public function __construct(iterable $subscribers)
    {
        $this->bus = new MessageBus(
            [
                new HandleMessageMiddleware(
                    new HandlersLocator(
                        reduce(function ($subscribers, DomainEventSubscriber $subscriber): array {
                            $subscribedEvents = $subscriber::subscribedTo();

                            foreach ($subscribedEvents as $subscribedEvent) {
                                $subscribers[$subscribedEvent][] = $subscriber;
                            }

                            return $subscribers;
                        }, $subscribers, [])
                    )
                ),
            ]
        );
    }

    public function publish(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            try {
                $this->bus->dispatch(new Envelope($event));
            } catch (NoHandlerForMessageException) {
                // throw exception optionally
            }
        }
    }
}
