<?php

namespace OpenWallet\Shared\Infrastructure\Laravel;

use Illuminate\Support\ServiceProvider;
use ReflectionClass;

abstract class DomainServiceProvider extends ServiceProvider
{
    /**
     * @var array<string, string>
     */
    protected array $repositories = [];

    /**
     * @var array<string>
     */
    protected array $commandHandlers = [];

    /**
     * @var array<string>
     */
    protected array $queryHandlers = [];

    /**
     * @var array<string>
     */
    protected array $eventSubscribers = [];

    public function register(): void
    {
        $this->registerRepositories();
        $this->tagCommandHandlers();
        $this->tagQueryHandlers();
        $this->tagEventSubscribers();
    }

    protected function registerRepositories(): void
    {
        foreach ($this->repositories as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }

    protected function tagCommandHandlers(): void
    {
        $this->app->tag(
            $this->commandHandlers,
            'command_handler'
        );
    }

    protected function tagQueryHandlers(): void
    {
        $this->app->tag(
            $this->queryHandlers,
            'query_handler'
        );
    }

    protected function tagEventSubscribers(): void
    {
        $this->app->tag(
            $this->eventSubscribers,
            'event_subscriber'
        );
    }

    protected function path(string $append = null): string
    {
        $reflection = new ReflectionClass($this);
        $path = realpath(dirname($reflection->getFileName(), 3));

        if (! $append) {
            return $path;
        }

        return $path.'/'.$append;
    }
}
