<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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


$router->post('/User', 'UserController@index');
$router->post('/refresh', 'UserController@refresh');



$router->group(['middleware' => ['validatecrsf', 'jwt.auth']], function () use ($router) {
    $router->get('/crsfReq', 'UserController@crsf');
    $router->post('/User/Register', 'UserController@register');
    $router->post('/Education', 'EducationController@index');
});
