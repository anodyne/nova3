<?php

Route::filter('api.auth', function()
{
	// Test against the presence of Basic Auth credentials
	$creds = [
		'username' => Request::getUser(),
		'password' => Request::getPassword(),
	];

	if ( ! Auth::attempt($creds))
	{
		return Response::json([
			'error' => true,
			'message' => 'Unauthorized Request'],
			401,
			['WWW-Authenticate' => 'Basic realm="NOVE REST API"']
		);
	}
});

Route::get('api/info', function()
{
	$data = [
		'api_version'   => Config::get('nova.api.version'),
		'nova_version'  => Config::get('nova.app.version'),
		'nova_url'      => str_replace(Request::path(), '', Request::url())
	];

	return Response::json($data, 200);
});

Route::group(['prefix' => 'api/v1'], function()
{
	/**
	 * User API
	 *
	 * GET		api/v1/user/{type}	Gets all users with the type specified
	 * GET		api/v1/user/{id}	Gets the user with the matching ID
	 * POST		api/v1/user			Create a new user
	 * PUT		api/v1/user/{id}	Update the user passed in the URI
	 * DELETE	api/v1/user/{id}	Delete the user passed in the URI
	 */
	Route::get('user/{type?}', 'Nova\Api\V1\User@index')->where('type', '[A-Za-z]+');
	Route::get('user/{id}', 'Nova\Api\V1\User@show')->where('id', '[0-9]+');
	Route::post('user', 'Nova\Api\V1\User@store');
	Route::put('user/{id}', 'Nova\Api\V1\User@update');
	Route::delete('user/{id}', 'Nova\Api\V1\User@destroy');
});