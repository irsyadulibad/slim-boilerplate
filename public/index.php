<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require base_path('bootstrap/app.php');

$app->addErrorMiddleware(env('APP_DEBUG', false), true, true);
$app->run();
