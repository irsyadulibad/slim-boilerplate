<?php

namespace App\Providers;

use Slim\App;

class RouteServiceProvider
{
    public function boot(App $app)
    {
        // Web router
        $app->group('', function() {
            require route_path('web');
        });
    }
}
