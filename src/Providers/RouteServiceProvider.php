<?php
declare(strict_types=1);

namespace Arctix\Support\Providers;

use Arctix\Support\ServiceProvider;
use Closure;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Routing\Router;
use Illuminate\Support\Traits\ForwardsCalls;

/**
 * RouteServiceProvider
 *
 * @author bu0nq <hello@bu0nq.ru>
 */
abstract class RouteServiceProvider extends ServiceProvider
{
    use ForwardsCalls;

    /**
     * @var string|null
     */
    protected string|null $namespace = null;

    /**
     * @var Closure|null
     */
    protected Closure|null $loadRoutesUsing = null;

    /**
     * @return void
     */
    public function register() : void
    {
        $this->booted(function () {
            $this->setRootControllerNamespace();

            if ($this->routesAreCached()) {
                $this->loadCachedRoutes();
            } else {
                $this->loadRoutes();

                $this->app->booted(function () {
                    $this->app['router']->getRoutes()->refreshNameLookups();
                    $this->app['router']->getRoutes()->refreshActionLookups();
                });
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
     * @return void
     */
    public function map() : void
    {
        //
    }

    /**
     * @return void
     */
    protected function setRootControllerNamespace() : void
    {
        if (!is_null($this->namespace)) {
            $this->app[UrlGenerator::class]->setRootControllerNamespace(
                $this->namespace
            );
        }
    }

    /**
     * @param Closure $routesCallback
     *
     * @return $this
     */
    protected function routes(
        Closure $routesCallback
    ) : static {
        $this->loadRoutesUsing = $routesCallback;

        return $this;
    }

    /**
     * @return bool
     */
    protected function routesAreCached() : bool
    {
        return $this->app->routesAreCached();
    }

    /**
     * @return void
     */
    protected function loadCachedRoutes() : void
    {
        $this->app->booted(function () {
            require $this->app->getCachedRoutesPath();
        });
    }

    /**
     * @return void
     */
    protected function loadRoutes() : void
    {
        if (!is_null($this->loadRoutesUsing)) {
            $this->app->call(
                $this->loadRoutesUsing
            );
        } elseif (method_exists($this, 'map')) {
            $this->app->call([
                $this, 'map'
            ]);
        }
    }

    /**
     * @param string $method
     * @param array $parameters
     *
     * @return mixed
     * @throws BindingResolutionException
     */
    public function __call(
        string $method, array $parameters
    ) : mixed {
        return $this->forwardCallTo(
            $this->app->make(Router::class), $method, $parameters
        );
    }
}
