<?php
declare(strict_types=1);

namespace Arctix\Supporting\Providers\Traits;

/**
 * IsDeferredTrait
 *
 * @author bu0nq <hello@bu0nq.ru>
 */
trait IsDeferredTrait
{
    /**
     * @return array
     */
    public function provides() : array
    {
        $provides = [];

        if (property_exists($this, 'providers') && $this->providers !== []) {
            foreach ($this->providers as $provider) {
                $instance = $this->app->resolveProvider($provider);

                $provides = array_merge(
                    $provides, $instance->provides()
                );
            }
        }

        return $provides;
    }
}
