<?php
declare(strict_types=1);

namespace Arctix\Supporting\Providers\Traits\Events;

use Illuminate\Support\Facades\Event;

/**
 * RegisterSubscribersTrait
 *
 * @author bu0nq <hello@bu0nq.ru>
 */
trait RegisterSubscribersTrait
{
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
