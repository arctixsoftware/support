<?php
declare(strict_types=1);

namespace Arctix\Support\Traits;

use Arctix\Support\Facades\Hash;

/**
 * HasPasswordTrait
 *
 * @author bu0nq <hello@bu0nq.ru>
 */
trait HasPasswordTrait
{
    /**
     * @param string $password
     *
     * @return string
     */
    protected function makePassword(
        string $password
    ) : string {
        return Hash::make($password);
    }
}
