<?php
declare(strict_types=1);

namespace Arctix\Support\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

/**
 * FilePathsFromTrait
 *
 * @author bu0nq <hello@bu0nq.ru>
 */
trait FilePathsFromTrait
{
    /**
     * @param string $path
     *
     * @return array
     */
    protected function filePathsFrom(
        string $path
    ) : array {
        $output = [];

        if (!File::isDirectory($path)) {
            return $output;
        }

        $files = File::allFiles($path);

        $files = Arr::sort($files, function ($file) {
            return $file->getFilename();
        });

        foreach ($files as $file) {
            $output[] = $file->getPathname();
        }

        return $output;
    }
}
