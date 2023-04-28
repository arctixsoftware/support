<?php
declare(strict_types=1);

namespace Arctix\Supporting\Providers\Traits\Events;

/**
 * RegisterObserversTrait
 *
 * @author bu0nq <hello@bu0nq.ru>
 */
trait RegisterObserversTrait
{
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
}
