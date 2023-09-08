<?php

namespace OpenWallet\Shared\Domain\ValueObject;

abstract class StringValueObject
{
    public function __construct(protected string $value)
    {
    }

    public static function from(string $value): static
    {
        return new static($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
