<?php

Route::get('test/citadel', function()
{
	$user = Sentry::getUserProvider();

	echo '<pre>';
	var_dump($user);
	echo '</pre>';
});

// Migrations
Route::get('migrate', function()
{
	// Set up for migrations
	Artisan::call('migrate:install');

	// Run the migrations
	Artisan::call('migrate');

	// Seed the database with dev data
	//Artisan::call('db:seed');

	// Uninstall everything
	//Artisan::call('migrate:reset', array('--package' => 'application'));

	return 'Migrations have run!';
});

Route::get('cache', function()
{
	// Cache something forever
	//Cache::forever('nova_module_list', array('foo', 'bar', 'test'));

	// Cache something for 1 minute
	//Cache::put('foo', 'FOO', 1);

	//Cache::forget('module_list');

	var_dump(Cache::get('nova_module_list'));
});

/**
 * Route includes from around the system.
 */

// Pull in the core routes
require_once SRCPATH.'Api/routes.php';
require_once SRCPATH.'Forum/routes.php';
require_once SRCPATH.'Setup/routes.php';
require_once SRCPATH.'Wiki/routes.php';

// Get the module list
$modules = Cache::get('nova_module_list', array());

// Loop through the modules and include their route files
foreach ($modules as $m)
{
	if (file_exists(APPPATH."module/{$m}/routes.php"))
	{
		include_once APPPATH."module/{$m}/routes.php";
	}
}
