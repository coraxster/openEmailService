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

$app->get('/', function () use ($app) {
    return $app->version() . ' - email service';
});




$app->group(['prefix' => 'v1', 'namespace' => 'v1'],  function ($app) {

    $app->post('send', 'EmailController@add');

    $app->get('config', 'EmailController@getConfig');

});