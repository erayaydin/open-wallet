<?php

namespace OpenWallet\Shared\Domain\Aggregate;

use OpenWallet\Shared\Domain\Bus\Event\PublishesDomainEvents;

abstract class AggregateRoot
{
    use PublishesDomainEvents;
}
