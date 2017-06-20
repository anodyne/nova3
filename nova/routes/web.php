<?php

Route::get('/', function () {
    return view('pages.welcome');
})->name('home');

Route::group(['namespace' => 'Nova\Auth\Http\Controllers'], function () {
	// Authentication Routes...
	Route::get('login', 'LoginController@showLoginForm')->name('login');
	Route::post('login', 'LoginController@login');
	Route::post('logout', 'LoginController@logout')->name('logout');

	// Password Reset Routes...
	Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
	Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
	Route::post('password/reset', 'ResetPasswordController@reset');
});

Route::get('join', function () {
	// Placeholder for the join page
})->name('join');

Route::resource('admin/roles', 'Nova\Authorize\Http\Controllers\RolesController');
Route::resource('admin/permissions', 'Nova\Authorize\Http\Controllers\PermissionsController');
