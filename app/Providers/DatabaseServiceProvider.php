<?php

namespace App\Providers;

use Illuminate\Database\Capsule\Manager;

class DatabaseServiceProvider
{
    public function boot()
    {
        $db = config('database');
        $manager = new Manager();
        
        $manager->addConnection(
            array_merge(['driver' => $db->default], $db->connections[$db->default])
        );
        $manager->setAsGlobal();
        $manager->bootEloquent();
    }
}
