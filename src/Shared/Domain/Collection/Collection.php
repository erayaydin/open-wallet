<?php

namespace OpenWallet\Shared\Domain\Collection;

use InvalidArgumentException;

abstract class Collection
{
    public function __construct(private readonly array $items = [])
    {
        $this->arrayOf($this->type(), $items);
    }

    public function count(): int
    {
        return count($this->all());
    }

    public function all(): array
    {
        return $this->items;
    }

    abstract protected function type(): string;

    private function arrayOf(string $class, array $items): void
    {
        foreach ($items as $item) {
            $this->instanceOf($class, $item);
        }
    }

    private function instanceOf(string $class, $item): void
    {
        if (! $item instanceof $class) {
            throw new InvalidArgumentException(
                sprintf('The object <%s> is not an instance of <%s>', $class, get_class($item))
            );
        }
    }
}
