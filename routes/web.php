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
    return $router->app->version();
});

$router->post('users/api/login', ['uses' => 'UsersController@getToken']);

/*
$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {
    $router->get('users', 'UsersController@index');
    $router->get('users/{id}', 'UsersController@showOneUser');
    $router->post('users', 'UsersController@createUser');
    $router->put('users/{id}', 'UsersController@updateUser');
    $router->delete('users/{id}', 'UsersController@deleteUser');
});
*/

$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {
//$router->group(['prefix' => 'api'], function($router){
    $router->get('users', 'UsersController@index');
    $router->get('users/{id}', 'UsersController@showOneUser');
    $router->post('users', 'UsersController@createUser');
    $router->put('users/{id}', 'UsersController@updateUser');
    $router->delete('users/{id}', 'UsersController@deleteUser');
});
