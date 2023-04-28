<?php
declare(strict_types=1);

namespace Arctix\Supporting\Providers;

use Arctix\Supporting\AbstractServiceProvider;
use Arctix\Supporting\Providers\Traits\HasNestedProvidersTrait;
use Arctix\Supporting\Providers\Traits\IsDeferredTrait;

/**
 * AbstractAggregateServiceProvider
 *
 * @author bu0nq <hello@bu0nq.ru>
 */
abstract class AbstractAggregateServiceProvider extends AbstractServiceProvider
{
    use HasNestedProvidersTrait, IsDeferredTrait;

    /**
     * @var array
     */
    protected array $providers = [];
}
