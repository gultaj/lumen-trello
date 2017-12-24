<?php

use App\User;
$app->group(['middleware' => 'cors'], function() use ($app) {
    $app->group(['prefix' => '/api/v1', 'namespace' => 'Api/v1', 'middleware' => 'auth'], function() use ($app) {
        $app->get('/', function () use ($app) {
            return $app->version();
        });
    });

    $app->post('/auth/login', 'AuthController@login');
    $app->post('/auth/register', 'AuthController@register');
});


$app->get('/users', function() use ($app) {
    return User::all();
});