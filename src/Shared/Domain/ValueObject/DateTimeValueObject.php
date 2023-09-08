<?php

namespace OpenWallet\Shared\Domain\ValueObject;

use DateTimeImmutable;

abstract class DateTimeValueObject
{
    public function __construct(protected DateTimeImmutable $value)
    {
    }

    public static function from(DateTimeImmutable $value): static
    {
        return new static($value);
    }

    public function getValue(): DateTimeImmutable
    {
        return $this->value;
    }
}
