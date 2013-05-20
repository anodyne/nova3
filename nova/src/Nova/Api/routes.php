<?php

Route::filter('apiAuth', function()
{
	// Test against the presence of Basic Auth credentials
	$creds = [
		'username' => Request::getUser(),
		'password' => Request::getPassword(),
	];

	if ( ! Auth::attempt($creds))
	{
		return Response::header('WWW-Authenticate', 'Basic realm="NovaAPI"')
			->json(['error' => true, 'message' => 'Unauthorized Request'], 401);
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
	Route::resource('user', 'Nova\Api\Controller\V1\User');
});

/*
require 'routes/logs.php';
require 'routes/posts.php';
require 'routes/missions.php';
require 'routes/characters.php';
require 'routes/announcements.php';
*/