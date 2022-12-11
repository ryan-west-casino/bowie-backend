<?php
use Illuminate\Http\Request;

/** @var \Laravel\Lumen\Routing\Router $router */

// Auth
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('auth/login', ['as' => 'auth.login', 'uses' => 'AuthController@login']);
    $router->get('auth/me', ['as' => 'auth.me', 'uses' => 'AuthController@me']);
    $router->get('auth/balance', ['as' => 'auth.balance', 'uses' => 'AuthController@balance']);
    $router->post('auth/transferToWallet', ['as' => 'auth.transferToWallet', 'uses' => 'AuthController@transferToWallet']);
    $router->post('auth/register', ['as' => 'auth.register', 'uses' => 'AuthController@register']);
    $router->post('auth/logout', ['as' => 'auth.logout', 'uses' => 'AuthController@logout']);
});


$router->get('/api/test', function () use ($router) {

    $users = \App\Models\User::all();
    return $users;
});