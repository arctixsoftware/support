<?php
declare(strict_types=1);

namespace Arctix\Supporting\Providers;

use Arctix\Supporting\AbstractServiceProvider;
use Arctix\Supporting\Providers\Traits\Events\RegisterListenersTrait;
use Arctix\Supporting\Providers\Traits\Events\RegisterObserversTrait;
use Arctix\Supporting\Providers\Traits\Events\RegisterSubscribersTrait;
use Arctix\Supporting\Providers\Traits\RegistersEventsTrait;

/**
 * AbstractEventServiceProvider
 *
 * @author bu0nq <hello@bu0nq.ru>
 */
abstract class AbstractEventServiceProvider extends AbstractServiceProvider
{
    use RegistersEventsTrait,
        RegisterListenersTrait,
        RegisterObserversTrait,
        RegisterSubscribersTrait;

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
}
