<?php
declare(strict_types=1);

namespace Arctix\Supporting\Providers\Traits;

use Illuminate\Foundation\Events\DiscoverEvents;

/**
 * RegistersEventsTrait
 *
 * @author bu0nq <hello@bu0nq.ru>
 */
trait RegistersEventsTrait
{
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
     * @return bool
     */
    public function shouldDiscoverEvents() : bool
    {
        return false;
    }
}
