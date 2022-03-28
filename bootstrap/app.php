<?php

use App\Kernel;
use DI\Bridge\Slim\Bridge;

$app = Bridge::create();

$dotenv = Dotenv\Dotenv::createImmutable(base_path());
$dotenv->load();

// Apply kernel function
Kernel::boot($app);

return $app;
