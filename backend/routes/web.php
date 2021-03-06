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
  return "You are in a right place ";
});

$router->group(['prefix' => 'api'], function () use ($router) {
  $router->get('book',  ['uses' => 'BookController@show']);
  $router->post('book',  ['uses' => 'BookController@store']);

  $router->get('category',  ['uses' => 'CategoryController@index']);
});