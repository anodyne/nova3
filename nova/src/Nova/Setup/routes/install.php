<?php
/**
 * Install routes
 *
 * These routes handle the installation of Nova 3.
 *
 * @package		Nova
 * @subpackage	Setup
 * @category	Route
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

Route::group(array('prefix' => 'setup/install'), function()
{
	Route::get('/', function()
	{
		return 'Install index';
	});

	Route::post('/', function()
	{
		// Run the migrations
		Artisan::call('migrate');

		// Seed the database with dev data
		Artisan::call('db:seed');

		// Cache

		// Register

		return Redirect::to('setup/install/settings');
	});

	Route::get('settings', function()
	{
		return 'Post-install setup';
	});

	Route::post('settings', function()
	{
		//

		return Redirect::to('setup/install/finalize');
	});

	Route::get('finalize', function()
	{
		return 'Post-install finalize';
	});
});