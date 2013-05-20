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
	Route::resource('user', 'Nova\Api\V1\User');
});