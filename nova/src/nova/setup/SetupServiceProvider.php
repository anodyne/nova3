<?php namespace nova\setup;

use Route;
use Illuminate\Support\ServiceProvider;

class SetupServiceProvider extends ServiceProvider {

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
			return new Setup;
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
			Route::get('/', 'nova\setup\controllers\Setup@getIndex');
			Route::get('start', 'nova\setup\controllers\Setup@getStart');
			Route::get('uninstall', 'nova\setup\controllers\Setup@getUninstall');
			Route::get('uninstall/cleanup', 'nova\setup\controllers\Setup@getUninstallCleanup');
			Route::get('genres', 'nova\setup\controllers\Setup@getGenres');

			Route::post('uninstall', 'nova\setup\controllers\Setup@postUninstall');
		});

		/**
		 * Building database config file
		 */
		Route::group(['prefix' => 'setup/config/db', 'before' => 'csrf'], function()
		{
			Route::get('/', 'nova\setup\controllers\ConfigDb@getIndex');
			Route::get('info', 'nova\setup\controllers\ConfigDb@getInfo');

			Route::post('check', 'nova\setup\controllers\ConfigDb@postCheck');
			Route::post('write', 'nova\setup\controllers\ConfigDb@postWrite');
			Route::post('verify', 'nova\setup\controllers\ConfigDb@postVerify');
		});

		/**
		 * Building email config file
		 */
		Route::group(['prefix' => 'setup/config/email', 'before' => 'csrf'], function()
		{
			Route::get('/', 'nova\setup\controllers\ConfigMail@getIndex');
			Route::get('info', 'nova\setup\controllers\ConfigMail@getInfo');
			
			Route::post('write', 'nova\setup\controllers\ConfigMail@postWrite');
			Route::post('verify', 'nova\setup\controllers\ConfigMail@postVerify');
		});

		/**
		 * Fresh install
		 */
		Route::group(['prefix' => 'setup/install', 'before' => 'csrf'], function()
		{
			Route::get('/', 'nova\setup\controllers\Install@getIndex');
			Route::get('settings', 'nova\setup\controllers\Install@getSettings');
			Route::get('finalize', 'nova\setup\controllers\Install@getFinalize');

			Route::post('/', 'nova\setup\controllers\Install@postIndex');
			Route::post('settings', 'nova\setup\controllers\Install@postSettings');
		});

		/**
		 * Migrate from Nova 2
		 */
		Route::group(['prefix' => 'setup/migrate', 'before' => 'csrf'], function()
		{
			Route::get('/', 'nova\setup\controllers\Setup@getStart');
		});

		/**
		 * Update Nova 3
		 */
		Route::group(['prefix' => 'setup/update', 'before' => 'csrf'], function()
		{
			Route::get('/', 'nova\setup\controllers\Update@getIndex');
			Route::get('finalize', 'nova\setup\controllers\Update@getFinalize');
			Route::get('rollback', 'nova\setup\controllers\Update@getRollback');
			Route::get('rollback/finalize', 'nova\setup\controllers\Update@getRollbackFinalize');

			Route::post('/', 'nova\setup\controllers\Update@postIndex');
			Route::post('rollback', 'nova\setup\controllers\Update@postRollback');
		});

		/**
		 * Setup ajax calls
		 */
		Route::group(['prefix' => 'setup/ajax', 'before' => 'csrf'], function()
		{
			Route::post('ignore_version', 'nova\setup\controllers\Ajax@postIgnoreVersion');
			Route::post('install_genre', 'nova\setup\controllers\Ajax@postInstallGenre');
			Route::post('uninstall_genre', 'nova\setup\controllers\Ajax@postUninstallGenre');
		});
	}

}