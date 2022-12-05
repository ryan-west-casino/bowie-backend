<?php
use Illuminate\Http\Request;

/** @var \Laravel\Lumen\Routing\Router $router */

// Auth
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('auth/login', ['as' => 'auth.login', 'uses' => 'AuthController@login']);
    $router->get('auth/me', ['as' => 'auth.me', 'uses' => 'AuthController@me']);
    $router->get('auth/balance', ['as' => 'auth.balance', 'uses' => 'AuthController@balance']);
    $router->post('auth/register', ['as' => 'auth.register', 'uses' => 'AuthController@register']);
    $router->post('auth/logout', ['as' => 'auth.logout', 'uses' => 'AuthController@logout']);
});