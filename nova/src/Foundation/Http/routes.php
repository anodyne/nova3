<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'Nova\Foundation\Http\Controllers\WelcomeController@index');

Route::get('home', 'Nova\Foundation\Http\Controllers\HomeController@index');

Route::controllers([
	'auth' => 'Nova\Foundation\Http\Controllers\Auth\AuthController',
	'password' => 'Nova\Foundation\Http\Controllers\Auth\PasswordController',
]);
