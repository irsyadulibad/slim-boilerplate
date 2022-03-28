<?php

use App\Http\Controllers\HomeController;
use App\Kernel;

$app = Kernel::$app;

$app->get('/', [HomeController::class, 'index']);
