<?php

/**
 * Get the routes from the cache and create them.
 */

// Get all routes
$routes = Cache::get('nova.routes');

if ($routes === null)
{
	Route::get('/', 'Nova\Core\Controller\Main@getIndex');
	Route::get('main/index', 'Nova\Core\Controller\Main@getIndex');

	Route::get('ajax/get/rank/image/{id}/{return}', 'Nova\Core\Controller\Ajax\Get@getRank');
	Route::get('ajax/get/position/{id}/{return}', 'Nova\Core\Controller\Ajax\Get@getPosition');

	Route::get('login', 'Nova\Core\Controller\Login@getIndex');
	Route::get('login/index', 'Nova\Core\Controller\Login@getIndex');
	Route::post('login/index', 'Nova\Core\Controller\Login@postIndex');

	Route::get('admin/main/index', 'Nova\Core\Controller\Admin\Main@getIndex');
	Route::get('admin/main/pages', 'Nova\Core\Controller\Admin\Main@getPages');
	Route::post('admin/main/pages', 'Nova\Core\Controller\Admin\Main@postPages');

	// The other option is to run a custom Artisan task that will generate the routes for the user
}
else
{
	// GET routes
	if (array_key_exists('get', $routes) and count($routes['get']) > 0)
	{
		foreach ($routes['get'] as $route)
		{
			Route::get($route['uri'], $route['resource']);
		}
	}

	// POST routes
	if (array_key_exists('post', $routes) and count($routes['post']) > 0)
	{
		foreach ($routes['post'] as $route)
		{
			Route::post($route['uri'], $route['resource']);
		}
	}

	// PUT routes
	if (array_key_exists('put', $routes) and count($routes['put']) > 0)
	{
		foreach ($routes['put'] as $route)
		{
			Route::put($route['uri'], $route['resource']);
		}
	}

	// DELETE routes
	if (array_key_exists('delete', $routes) and count($routes['delete']) > 0)
	{
		foreach ($routes['delete'] as $route)
		{
			Route::delete($route['uri'], $route['resource']);
		}
	}
}

/**
 * Route includes from around the system.
 */

// Pull in the core routes
require SRCPATH.'Api/routes.php';
require SRCPATH.'Forum/routes.php';
require SRCPATH.'Setup/routes.php';
require SRCPATH.'Wiki/routes.php';

// Get the module list
$modules = Cache::get('nova.modules', array());

// Loop through the modules and include their route files
foreach ($modules as $m)
{
	if (File::exists(APPPATH."module/{$m}/routes.php"))
	{
		include APPPATH."module/{$m}/routes.php";
	}
}

// Pull in the test routes if we're local
if (App::environment() == 'local')
{
	require SRCPATH.'Core/routes/test.php';
}