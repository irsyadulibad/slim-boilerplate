<?php

namespace App;

use Slim\App;

class Kernel
{
    public static App $app;

    protected static $providers = [
        \App\Providers\RouteServiceProvider::class,
        \App\Providers\DatabaseServiceProvider::class,
        \App\Providers\ViewServiceProvider::class,
    ];

    protected static $middlewares = [
        
    ];

    public static function boot(App $app)
    {
        static::$app = $app;

        // Load Providers
        foreach(static::$providers as $provider) {
            (new $provider)->boot($app);
        }

        // Load Middleware
        foreach(static::$middlewares as $middleware) {
            $app->add(new $middleware);
        }
    }
}
