<?php

Route::group(array('prefix' => 'setup/utilities'), function()
{
	/**
	 * Uninstall Nova.
	 */
	Route::get('uninstall', function()
	{
		return 'Uninstall Nova';
	});
	Route::post('uninstall', function()
	{
		// Do the QuickInstall removals
		ModuleCatalogModel::uninstall();
		RankCatalogModel::uninstall();
		SkinCatalogModel::uninstall();
		WidgetCatalogModel::uninstall();

		// Uninstall Nova
		Artisan::call('migrate:reset', array('--path' => 'nova/src/Nova/Setup/database/migrations'));

		// Remove the system install cache
		Cache::forget('nova_system_installed');

		return Redirect::to('setup');
	});

	Route::get('genres', function()
	{
		return 'Genre Panel';
	});

	Route::get('database', function()
	{
		return 'Database panel';
	});
});