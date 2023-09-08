<?php

namespace OpenWallet\Shared\Domain\Bus\Event;

use DateTimeImmutable;
use OpenWallet\Shared\Domain\ValueObject\UuidValueObject;

abstract class DomainEvent
{
    public function __construct(
        private readonly string $id,
        private ?string $eventId = null,
        private ?string $occurredOn = null
    ) {
        $this->eventId = $eventId ?? UuidValueObject::random()->getValue();
        $this->occurredOn = $this->occurredOn ?? (new DateTimeImmutable())->format('Y-m-d H:i:s.u T');
    }

    abstract public static function from(
        string $id,
        array $body,
        string $eventId,
        string $occurredOn
    ): self;

    abstract public static function eventName(): string;

    abstract public function to(): array;

    public function getId(): string
    {
        return $this->id;
    }

    public function getEventId(): string
    {
        return $this->eventId;
    }

    public function getOccurredOn(): string
    {
        return $this->occurredOn;
    }
}
