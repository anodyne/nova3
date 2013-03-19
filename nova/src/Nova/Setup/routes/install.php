<?php

Route::group(array('prefix' => 'setup/install'), function()
{
	Route::get('/', function()
	{
		return 'Install index';
	});

	Route::post('/', function()
	{
		// Make sure we don't time out
		set_time_limit(0);

		// Run the migrations
		Artisan::call('migrate', array('--path' => 'nova/src/Nova/Setup/database/migrations'));

		// Do the quick installs
		ModuleCatalog::install();
		RankCatalog::install();
		SkinCatalog::install();
		WidgetCatalog::install();

		// Seed the database with dev data if necessary
		if (Config::get('nova.use_dev_data'))
		{
			Artisan::call('db:seed');
		}
		
		// Clear the entire cache
		Cache::flush();

		// Cache the headers
		SiteContentModel::getSectionContent('header', 'main');
		SiteContentModel::getSectionContent('header', 'sim');
		SiteContentModel::getSectionContent('header', 'personnel');
		SiteContentModel::getSectionContent('header', 'search');
		SiteContentModel::getSectionContent('header', 'login');
		
		// Cache the titles
		SiteContentModel::getSectionContent('title', 'main');
		SiteContentModel::getSectionContent('title', 'sim');
		SiteContentModel::getSectionContent('title', 'personnel');
		SiteContentModel::getSectionContent('title', 'search');
		SiteContentModel::getSectionContent('title', 'login');
		
		// Cache the messages
		SiteContentModel::getSectionContent('message', 'main');
		SiteContentModel::getSectionContent('message', 'sim');
		SiteContentModel::getSectionContent('message', 'personnel');
		SiteContentModel::getSectionContent('message', 'search');
		SiteContentModel::getSectionContent('message', 'login');

		// Register
		# TODO: need to figure out how we want to do registration

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