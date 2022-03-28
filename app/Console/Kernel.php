<?php

namespace App\Console;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Slim\App;
use Symfony\Component\Console\Application;

class Kernel
{
    public static function boot(Application $cli): void
    {
        $commands = static::mapDir(__DIR__ . '/Commands/');
        
        foreach($commands as $command) {
            $cli->add(new $command);
        }
    }

    private static function mapDir(string $dir): array
    {
        $iterator = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($iterator);
        $commands = [];

        foreach($files as $file) {
            $namespace = static::convertNamespace($file->getPath());
            $commands[] = "{$namespace}\\{$file->getBaseName('.php')}";
        }

        return $commands;
    }

    private static function convertNamespace(string $dir): string
    {
        $search = __DIR__ . '/Commands';
        $replaced = str_replace($search, "App\\Console\\Commands", $dir);

        return str_replace("/", "\\", $replaced);
    }
}
