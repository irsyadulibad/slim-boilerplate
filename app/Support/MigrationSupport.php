<?php

namespace App\Support;

use FilesystemIterator;
use Illuminate\Database\Capsule\Manager;
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

    public static function getMigration(string $name)
    {
        $path = base_path("database/migrations/{$name}.php");
        if(!file_exists($path)) return null;

        return (object) [
            'path' => $path,
            'class' => cap_after('_', substr($name, 18)),
            'name' => $name
        ];
    }

    public static function getMigratedFiles(): array
    {
        return Manager::table('migrations')->pluck('migration')->toArray();
    }
}
