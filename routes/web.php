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

$router->group(['middleware' => 'cors'], function () use ($router) {
    $router->get('signatures','SignatureController@allGuest');
    $router->post('create/signatures','SignatureController@createVisitor');
    $router->get('signature/{id}','SignatureController@showGuest');
    $router->get('signature/signout','SignatureController@signOutGuest');
    $router->post('sigin','SignatureController@signin');
    $router->get('signature/signoutwithid','SignatureController@signOutWithId');

});


