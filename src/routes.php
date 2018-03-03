<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes
$app->group(
    '/api/v1',
    function () use ($app) {
        $app->get('/users', 'App\Controllers\UserController:index');
        $app->get('/users/{id}', 'App\Controllers\UserController:show');
        $app->post('/users', 'App\Controllers\UserController:store');
    }
);