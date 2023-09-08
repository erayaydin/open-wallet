<?php

namespace OpenWallet\Shared\Domain\ValueObject;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

abstract class UuidValueObject
{
    public function __construct(protected string $value)
    {
        $this->assertValidUuid($value);
    }

    public static function from(string $value): static
    {
        return new static($value);
    }

    public static function random(): static
    {
        return new static(Uuid::uuid4()->toString());
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertValidUuid(string $id): void
    {
        if (! Uuid::isValid($id)) {
            throw new InvalidArgumentException(
                sprintf('`<%s>` does not allow the value `<%s>`.', static::class, $id)
            );
        }
    }
}
