<?php
declare(strict_types=1);

namespace Arctix\Support;

/**
 * BootstrapServiceProvider
 *
 * @author bu0nq <hello@bu0nq.ru>
 */
abstract class BootstrapServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected array $providers = [];

    /**
     * @var array
     */
    protected array $instances = [];

    /**
     * @return void
     */
    public function register() : void
    {
        $this->instances = [];

        foreach ($this->providers as $provider) {
            $this->instances[] = $this->app->register($provider);
        }
    }

    /**
     * @return array
     */
    public function provides() : array
    {
        $provides = [];

        foreach ($this->providers as $provider) {
            $instance = $this->app->resolveProvider($provider);

            $provides = array_merge(
                $provides, $instance->provides()
            );
        }

        return $provides;
    }

    /**
     * @param array $providers
     */
    protected function mergeServiceProviders(
        array $providers
    ) : void {
        $this->providers = array_merge(
            $this->providers, $providers
        );
    }
}
