<?php

use App\Exceptions\ConfigException;
use App\Support\ViewSupport;

if(!function_exists('base_path')) {
    function base_path(string $path = '') {
        return __DIR__ . "/../{$path}";
    }
}

if(!function_exists('public_path')) {
    function public_path(string $path = '') {
        return base_path("public/{$path}");
    }
}

if(!function_exists('app_path')) {
    function app_path(string $path = '') {
        return base_path("app/{$path}");
    }
}

if(!function_exists('route_path')) {
    function route_path(string $path = '') {
        return base_path("routes/{$path}.php");
    }
}

if(!function_exists('config')) {
    function config(string $name) {
        $exp = explode('.', $name);
        $path = base_path("config/{$exp[0]}.php");
        
        if(!file_exists($path)) throw new ConfigException("Config file not found");
        $config = require $path;

        if(isset($exp[1])) {
            return $config[$exp[1]] ?? null;
        }

        return (object)$config;
    }
}

if(!function_exists('view')) {
    function view(string $name, array $data = []) {
        return ViewSupport::$factory->render("{$name}.latte", $data);
    }
}

if(!function_exists('cap_after')) {
    function cap_after(string $delimiter, string $value) {
        $pattern = "/{$delimiter}([a-z]?)/";

        return preg_replace_callback($pattern, function($match) {
            return strtoupper($match[1]);
        }, $value);
    }
}

if(!function_exists('load_stub')) {
    function load_stub(string $name, ...$args) {
        $path = base_path("storage/stubs/$name.stub");
        $content = file_get_contents($path);

        return sprintf($content, ...$args);
    }
}

if(!function_exists('make_dirs')) {
    function make_dirs(string $basePath, array $dirs):string {
        $finalPath = array_reduce($dirs, function($path = '', $dir) use($basePath) {
            $path = $path .= "$dir/";
            $fullPath = "{$basePath}/" . $path;

            if(!is_dir($fullPath)) mkdir($fullPath);
            return $path;
        });

        return ("{$basePath}/" . $finalPath);
    }
}
