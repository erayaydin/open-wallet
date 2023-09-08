<?php

namespace OpenWallet\Shared\Infrastructure\Laravel;

use Illuminate\Support\ServiceProvider;
use OpenWallet\Shared\Domain\Bus\Command\CommandBus;
use OpenWallet\Shared\Domain\Bus\Event\EventBus;
use OpenWallet\Shared\Domain\Bus\Query\QueryBus;
use OpenWallet\Shared\Infrastructure\Bus\Messenger\MessengerCommandBus;
use OpenWallet\Shared\Infrastructure\Bus\Messenger\MessengerEventBus;
use OpenWallet\Shared\Infrastructure\Bus\Messenger\MessengerQueryBus;

class BusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            EventBus::class,
            function ($app) {
                return new MessengerEventBus($app->tagged('event_subscriber'));
            }
        );

        $this->app->bind(
            QueryBus::class,
            function ($app) {
                return new MessengerQueryBus($app->tagged('query_handler'));
            }
        );

        $this->app->bind(
            CommandBus::class,
            function ($app) {
                return new MessengerCommandBus($app->tagged('command_handler'));
            }
        );
    }
}
