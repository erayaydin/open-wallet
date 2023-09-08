<?php

namespace OpenWallet\Shared\Infrastructure\Laravel\Traits;

use OpenWallet\Shared\Domain\Bus\Query\Query;
use OpenWallet\Shared\Domain\Bus\Query\QueryBus;
use OpenWallet\Shared\Domain\Bus\Query\Response;

trait AsksQuery
{
    public function askQuery(Query $query): Response
    {
        return app(QueryBus::class)->ask($query);
    }
}
