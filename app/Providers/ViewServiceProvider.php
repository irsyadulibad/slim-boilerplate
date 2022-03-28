<?php

namespace App\Providers;

use App\Support\ViewSupport;
use Latte\Engine;
use Latte\Loaders\FileLoader;

class ViewServiceProvider
{
    public function boot()
    {
        $latte = new Engine;
        $loader = new FileLoader(base_path('resources/views'));

        $latte->setLoader($loader);
        $latte->setAutoRefresh(env('APP_DEBUG', false));
        $latte->setTempDirectory(base_path('storage/cache/view'));

        ViewSupport::$factory = $latte;
    }
}
