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
$router->post('register', ['uses' => 'AuthController@register']);

$router->post('login', ['uses' => 'AuthController@login']);


$router->group(['prefix' => 'api/v1', 'middleware' => ['auth:api']], function () use ($router) {
    $router->group(['prefix' => 'admin', 'middleware' => ['admin']], function () use ($router) {
    $router->post('create_package', ['uses' => 'AdminController@createPackage']);
    });
});


