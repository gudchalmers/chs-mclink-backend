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

use Illuminate\Support\Facades\Hash;

$router->get('[{path:.*}]', ['as' => 'home', function () use ($router) {
    return view('home');
}]);

$router->post('/register', ['middleware' => ['token'], 'uses' => 'McController@register']);
$router->post('/verify', ['middleware' => ['token'], 'uses' => 'McController@verify']);
$router->post('/unregister', ['middleware' => ['token'], 'uses' => 'McController@unregister']);
$router->post('/check', ['middleware' => ['token'], 'uses' => 'McController@check']);
