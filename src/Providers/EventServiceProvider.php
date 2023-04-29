<?php
declare(strict_types=1);

namespace Arctix\Support\Providers;

use Arctix\Support\ServiceProvider;
use Closure;
use Illuminate\Foundation\Events\DiscoverEvents;
use Illuminate\Support\Facades\Event;

/**
 * EventServiceProvider
 *
 * @author bu0nq <hello@bu0nq.ru>
 */
abstract class EventServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected array $listeners = [];

    /**
     * @var array
     */
    protected array $observers = [];

    /**
     * @var array
     */
    protected array $subscribers = [];

    /**
     * @return void
     */
    public function register() : void
    {
        $this->booting(function () {
            $this->registerListeners($this->getEvents());

            if ($this->observers !== []) {
                $this->registerObservers($this->observers);
            }

            if ($this->subscribers !== []) {
                $this->registerSubscribers($this->subscribers);
            }
        });
    }

    /**
     * @return void
     */
    public function boot() : void
    {
        //
    }
    
    /**
     * @return array
     */
    public function listeners() : array
    {
        return $this->listeners ?? [];
    }

    /**
     * @return array
     */
    public function getEvents() : array
    {
        if ($this->app->eventsAreCached()) {
            $cache = require $this->app->getCachedEventsPath();

            return $cache[get_class($this)] ?? [];
        } else {
            return array_merge_recursive(
                $this->discoveredEvents(), $this->listeners()
            );
        }
    }

    /**
     * @return array
     */
    public function discoverEvents() : array
    {
        return collect($this->discoverEventsWithin())
            ->reject(function ($directory) {
                return !is_dir($directory);
            })
            ->reduce(function ($discovered, $directory) {
                return array_merge_recursive(
                    $discovered,
                    DiscoverEvents::within($directory, $this->eventDiscoveryBasePath())
                );
            }, []);
    }

    /**
     * @return bool
     */
    public function shouldDiscoverEvents() : bool
    {
        return false;
    }

    /**
     * @return array
     */
    protected function discoveredEvents() : array
    {
        return $this->shouldDiscoverEvents() ? $this->discoverEvents() : [];
    }

    /**
     * @return array
     */
    protected function discoverEventsWithin() : array
    {
        return [
            $this->app->path('Listeners'),
        ];
    }

    /**
     * @return string
     */
    protected function eventDiscoveryBasePath() : string
    {
        return base_path();
    }

    /**
     * @param Closure|array|string $events
     * @param Closure|array|string|null $listener
     */
    private function registerListener(
        Closure|array|string $events, Closure|array|string|null $listener = null
    ) : void {
        Event::listen($events, $listener);
    }

    /**
     * @param array $events
     */
    private function registerListeners(
        array $events
    ) : void {
        foreach ($events as $event => $listeners) {
            foreach (array_unique($listeners, SORT_REGULAR) as $listener) {
                $this->registerListener($event, $listener);
            }
        }
    }

    /**
     * @param string $model
     * @param array|object|string $classes
     */
    private function registerObserver(
        string $model, array|object|string $classes
    ) : void {
        $model::observe($classes);
    }

    /**
     * @param array $observers
     */
    private function registerObservers(
        array $observers
    ) : void {
        foreach ($observers as $model => $classes) {
            $this->registerObserver($model, $classes);
        }
    }

    /**
     * @param object|string $subscriber
     */
    private function registerSubscriber(
        object|string $subscriber
    ) : void {
        Event::subscribe($subscriber);
    }

    /**
     * @param array $subscribers
     */
    private function registerSubscribers(
        array $subscribers
    ) : void {
        foreach ($subscribers as $subscriber) {
            $this->registerSubscriber($subscriber);
        }
    }
}
