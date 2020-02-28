<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return 'User API using ' . $router->app->version();
});

$router->group(['prefix' => 'api/v1'], function ($app) {
    $app->post('user', 'UserController@createUser');
    $app->put('user/{id}', 'UserController@updateUser');

    $app->delete('user/{id}', 'UserController@deleteUser');
    $app->get('users', 'UserController@index');
    $app->get('user/{id}', 'UserController@getUser');
    $app->post('users', 'UserController@getUsersByIds');
});
