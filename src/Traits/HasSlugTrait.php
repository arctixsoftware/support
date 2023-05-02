<?php
declare(strict_types=1);

namespace Arctix\Support\Traits;

use Illuminate\Support\Str;

/**
 * HasSlugTrait
 *
 * @author bu0nq <hello@bu0nq.ru>
 */
trait HasSlugTrait
{
    /**
     * @param string $slug
     *
     * @return string
     */
    protected function makeSlug(
        string $slug
    ) : string {
        return Str::slug($slug);
    }
}
