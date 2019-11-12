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

$router->group(['prefix' => 'signature/'], function () use ($router) {
	$router->get('','SignatureController@allGuest');
	$router->post('/create','SignatureController@createVisitor');
	$router->get('{id}','SignatureController@showGuest');
	// $router->get('signout','SignatureController@signOutGuest');
	$router->post('sigin','SignatureController@signin');
	// $router->get('signoutwithid','SignatureController@signOutWithId');
    $router->post('edit/{id}','SignatureController@editGuest');
	$router->get('delete/{id}','SignatureController@deleteGuest');
});  



