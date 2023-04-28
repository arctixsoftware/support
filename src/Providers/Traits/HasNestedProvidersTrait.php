<?php
declare(strict_types=1);

namespace Arctix\Supporting\Providers\Traits;

/**
 * HasNestedProvidersTrait
 *
 * @author bu0nq <hello@bu0nq.ru>
 */
trait HasNestedProvidersTrait
{
    /**
     * @var array
     */
    protected array $instances = [];

    /**
     * @param array $providers
     */
    protected function mergeServiceProviders(
        array $providers = []
    ) : void {
        $this->instances = [];

        if (property_exists($this, 'providers')) {
            $this->providers = array_merge(
                $this->providers, $providers
            );

            $providers = $this->providers;
        }

        foreach ($providers as $provider) {
            $this->instances[] = $this->app->register($provider);
        }
    }
}
