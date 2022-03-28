<?php

namespace App\Support;

use FilesystemIterator;
use RecursiveDirectoryIterator;

class MigrationSupport
{
    public static function migrations()
    {
        $path = base_path('database/migrations');
        $iterator = new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS);

        return array_map(function($file) {
            $baseName = $file->getBaseName('.php');

            return (object) [
                'path' => $file->getPathName(),
                'class' => cap_after('_', substr($baseName, 18)),
                'name' => $baseName
            ];
        }, iterator_to_array($iterator));
    }
}
