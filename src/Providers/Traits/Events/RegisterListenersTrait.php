<?php
declare(strict_types=1);

namespace Arctix\Supporting\Providers\Traits\Events;

use Closure;
use Illuminate\Support\Facades\Event;

/**
 * RegisterListenersTrait
 *
 * @author bu0nq <hello@bu0nq.ru>
 */
trait RegisterListenersTrait
{
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
}
