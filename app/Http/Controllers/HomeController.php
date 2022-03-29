<?php

namespace App\Http\Controllers;

use Slim\Psr7\Response;

class HomeController
{
    public function index(Response $response)
    {
        view('home');
        return $response;
    }
}
