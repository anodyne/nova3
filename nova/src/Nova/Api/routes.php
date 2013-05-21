<?php

Route::filter('api.auth', function()
{
	return Auth::onceBasic();
});

Route::group(['prefix' => '{api}/v1'], function()
{
	/**
	 * API Info
	 *
	 * API Version
	 * Nova Version
	 * Nova Base URL
	 */
	Route::get('info', function()
	{
		return Response::api([
			'api_version'	=> Config::get('nova.api.version'),
			'nova_version'	=> Config::get('nova.app.version'),
			'nova_url'		=> str_replace(Request::path(), '', Request::url())
		], 200);
	});

	/**
	 * User API
	 *
	 * GET		api/v1/user/{type}/{page}	Gets all users with the type specified
	 * GET		api/v1/user/{id}			Gets the user with the matching ID
	 * POST		api/v1/user					Create a new user
	 * PUT		api/v1/user/{id}			Update the user passed in the URI
	 * DELETE	api/v1/user/{id}			Delete the user passed in the URI
	 */
	Route::get('user/{type?}/{page?}', 'Nova\Api\V1\User@index')->where('type', '[A-Za-z]+');
	Route::get('user/{id}', 'Nova\Api\V1\User@show')->where('id', '[0-9]+');
	Route::post('user', 'Nova\Api\V1\User@store');
	Route::put('user/{id}', 'Nova\Api\V1\User@update');
	Route::delete('user/{id}', 'Nova\Api\V1\User@destroy');
});