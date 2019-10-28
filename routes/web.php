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
        //CRUD PACKAGE
        $router->get('package/{admin_id}', ['uses' => 'AdminController@showPackage']);
        $router->post('package', ['uses' => 'AdminController@createPackage']);
        $router->put('package/{package_id}', ['uses' => 'AdminController@updatePackage']);
        $router->delete('package/{package_id}', ['uses' => 'AdminController@deletePackage']);

        //CRUD TRAINER 
        $router->get('all-trainer/{admin_id}', ['uses' => 'AdminController@showAllTrainer']);
        $router->get('trainer/{trainer_id}', ['uses' => 'AdminController@showTrainer']);
        $router->post('trainer', ['uses' => 'AdminController@createTrainer']);
        $router->put('trainer/{trainer_id}', ['uses' => 'AdminController@updateTrainer']);
        $router->delete('trainer/{trainer_id}', ['uses' => 'AdminController@deleteTrainer']);
    });


    $router->group(['prefix' => 'trainer', 'middleware' => ['trainer']], function () use ($router) {
        $router->get('profile', ['uses' => 'TrainerController@showProfile']);
        $router->put('profile/{trainer_id}', ['uses' => 'TrainerController@updateProfile']);
    });
});


