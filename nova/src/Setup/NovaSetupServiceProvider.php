<?php namespace Nova\Setup;

use Route;
use Illuminate\Support\ServiceProvider;

class NovaSetupServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->registerSetup();
	}

	public function boot()
	{
		$this->bootSetupRoutes();
	}

	/**
	 * The Setup class provides methods for working with the base Nova setup
	 * and for checking the install status and the availability of updates.
	 */
	protected function registerSetup()
	{
		$this->app['nova.setup'] = $this->app->share(function($app)
		{
			return new SetupService;
		});
	}

	/**
	 * Setup the routes used by the setup package.
	 */
	protected function bootSetupRoutes()
	{
		/**
		 * Setup Center
		 */
		Route::group(['prefix' => 'setup', 'before' => 'csrf'], function()
		{
			Route::get('/', 'Nova\Setup\Controllers\SetupController@getIndex');
			Route::get('start', 'Nova\Setup\Controllers\SetupController@getStart');
			Route::get('uninstall', 'Nova\Setup\Controllers\SetupController@getUninstall');
			Route::get('uninstall/cleanup', 'Nova\Setup\Controllers\SetupController@getUninstallCleanup');
			Route::get('genres', 'Nova\Setup\Controllers\SetupController@getGenres');

			Route::post('uninstall', 'Nova\Setup\Controllers\SetupController@postUninstall');
		});

		/**
		 * Building database config file
		 */
		Route::group(['prefix' => 'setup/config/db', 'before' => 'csrf'], function()
		{
			Route::get('/', 'Nova\Setup\Controllers\ConfigDbController@getIndex');
			Route::get('info', 'Nova\Setup\Controllers\ConfigDbController@getInfo');

			Route::post('check', 'Nova\Setup\Controllers\ConfigDbController@postCheck');
			Route::post('write', 'Nova\Setup\Controllers\ConfigDbController@postWrite');
			Route::post('verify', 'Nova\Setup\Controllers\ConfigDbController@postVerify');
		});

		/**
		 * Building email config file
		 */
		Route::group(['prefix' => 'setup/config/email', 'before' => 'csrf'], function()
		{
			Route::get('/', 'Nova\Setup\Controllers\ConfigMailController@getIndex');
			Route::get('info', 'Nova\Setup\Controllers\ConfigMailController@getInfo');
			
			Route::post('write', 'Nova\Setup\Controllers\ConfigMailController@postWrite');
			Route::post('verify', 'Nova\Setup\Controllers\ConfigMailController@postVerify');
		});

		/**
		 * Fresh install
		 */
		Route::group(['prefix' => 'setup/install', 'before' => 'csrf'], function()
		{
			Route::get('/', 'Nova\Setup\Controllers\InstallController@getIndex');
			Route::get('settings', 'Nova\Setup\Controllers\InstallController@getSettings');
			Route::get('finalize', 'Nova\Setup\Controllers\InstallController@getFinalize');

			Route::post('/', 'Nova\Setup\Controllers\InstallController@postIndex');
			Route::post('settings', 'Nova\Setup\Controllers\InstallController@postSettings');
		});

		/**
		 * Migrate from Nova 2
		 */
		Route::group(['prefix' => 'setup/migrate', 'before' => 'csrf'], function()
		{
			Route::get('/', 'Nova\Setup\Controllers\SetupController@getStart');
		});

		/**
		 * Update Nova 3
		 */
		Route::group(['prefix' => 'setup/update', 'before' => 'csrf'], function()
		{
			Route::get('/', 'Nova\Setup\Controllers\UpdateController@getIndex');
			Route::get('finalize', 'Nova\Setup\Controllers\UpdateController@getFinalize');
			Route::get('rollback', 'Nova\Setup\Controllers\UpdateController@getRollback');
			Route::get('rollback/finalize', 'Nova\Setup\Controllers\UpdateController@getRollbackFinalize');

			Route::post('/', 'Nova\Setup\Controllers\UpdateController@postIndex');
			Route::post('rollback', 'Nova\Setup\Controllers\UpdateController@postRollback');
		});

		/**
		 * Setup ajax calls
		 */
		Route::group(['prefix' => 'setup/ajax', 'before' => 'csrf'], function()
		{
			Route::post('ignore_version', 'Nova\Setup\Controllers\AjaxController@postIgnoreVersion');
			Route::post('install_genre', 'Nova\Setup\Controllers\AjaxController@postInstallGenre');
			Route::post('uninstall_genre', 'Nova\Setup\Controllers\AjaxController@postUninstallGenre');
		});
	}

}