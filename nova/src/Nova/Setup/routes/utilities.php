<?php

Route::group(array('prefix' => 'setup/utilities', 'before' => 'configFileCheck|setupAuthorization|csrf'), function()
{
	/**
	 * Uninstall Nova.
	 */
	Route::get('uninstall', function()
	{
		$data = new stdClass;
		$data->view = 'utilities/remove';
		$data->jsView = 'utilities/remove_js';
		$data->title = 'Uninstall Nova';
		$data->layout = new stdClass;
		$data->layout->label = 'Uninstall Nova';
		$data->steps = false;
		$data->content = new stdClass;
		$data->content->message = Lang::get('setup.remove.instructions');

		$data->controls = HTML::to('setup', "I don't want to do this, get me out of here", array('class' => 'pull-right'));
		$data->controls.= Form::open('setup/utilities/uninstall').
			Form::button('Uninstall', array('class' => 'btn btn-danger', 'id' => 'next', 'name' => 'submit')).
			Form::hidden('csrf_token', csrf_token()).
			Form::close();

		return setupTemplate($data);
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
		if (File::exists(APPPATH.'storage/cache/nova_system_installed'))
		{
			Cache::forget('nova_system_installed');
		}

		return Redirect::to('setup');
	});

	/**
	 * Genre Panel.
	 */
	Route::get('genres', function()
	{
		return 'Genre Panel';
	});
	Route::post('genres', function()
	{
		return 'Genre Panel POST';
	});

	/**
	 * Database Panel.
	 */
	Route::get('database', function()
	{
		return 'Database panel';
	});
});