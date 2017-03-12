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
    return json_encode(['code' => 0]);
});
$app->group(['namespace' => 'v1', 'prefix' => 'api/v1','middleware'=>['auth']], function () use ($app) {
    $app->get('/', 'IndexController@index');
});