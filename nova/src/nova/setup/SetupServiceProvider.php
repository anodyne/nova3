<?php namespace Nova\Setup;

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

	protected function registerSetup()
	{
		$this->app['nova.setup'] = $this->app->share(function($app)
		{
			return new Setup;
		});
	}

	protected function bootSetupRoutes()
	{
		/**
		 * Setup Center
		 */
		$this->app['router']->group(['prefix' => 'setup', 'before' => 'csrf'], function()
		{
			$this->app['router']->get('/', 'Nova\Setup\Controllers\Setup@getIndex');
			$this->app['router']->get('start', 'Nova\Setup\Controllers\Setup@getStart');
			$this->app['router']->get('uninstall', 'Nova\Setup\Controllers\Setup@getUninstall');
			$this->app['router']->get('uninstall/cleanup', 'Nova\Setup\Controllers\Setup@getUninstallCleanup');
			$this->app['router']->get('genres', 'Nova\Setup\Controllers\Setup@getGenres');

			$this->app['router']->post('uninstall', 'Nova\Setup\Controllers\Setup@postUninstall');
		});

		/**
		 * Building database config file
		 */
		$this->app['router']->group(['prefix' => 'setup/config/db', 'before' => 'csrf'], function()
		{
			$this->app['router']->get('/', 'Nova\Setup\Controllers\ConfigDb@getIndex');
			$this->app['router']->get('info', 'Nova\Setup\Controllers\ConfigDb@getInfo');

			$this->app['router']->post('check', 'Nova\Setup\Controllers\ConfigDb@postCheck');
			$this->app['router']->post('write', 'Nova\Setup\Controllers\ConfigDb@postWrite');
			$this->app['router']->post('verify', 'Nova\Setup\Controllers\ConfigDb@postVerify');
		});

		/**
		 * Building email config file
		 */
		$this->app['router']->group(['prefix' => 'setup/config/email', 'before' => 'csrf'], function()
		{
			$this->app['router']->get('/', 'Nova\Setup\Controllers\ConfigMail@getIndex');
			$this->app['router']->get('info', 'Nova\Setup\Controllers\ConfigMail@getIndex');
			
			$this->app['router']->post('write', 'Nova\Setup\Controllers\ConfigMail@postWrite');
			$this->app['router']->post('verify', 'Nova\Setup\Controllers\ConfigMail@postVerify');
		});

		/**
		 * Fresh install
		 */
		$this->app['router']->group(['prefix' => 'setup/install', 'before' => 'csrf'], function()
		{
			$this->app['router']->get('/', 'Nova\Setup\Controllers\Setup@getStart');
			$this->app['router']->get('settings', 'Nova\Setup\Controllers\Install@getSettings');
			$this->app['router']->get('finalize', 'Nova\Setup\Controllers\Install@getFinalize');

			$this->app['router']->post('/', 'Nova\Setup\Controllers\Install@postIndex');
			$this->app['router']->post('settings', 'Nova\Setup\Controllers\Install@postSettings');
		});

		/**
		 * Migrate from Nova 2
		 */
		$this->app['router']->group(['prefix' => 'setup/migrate', 'before' => 'csrf'], function()
		{
			$this->app['router']->get('/', 'Nova\Setup\Controllers\Setup@getStart');
		});

		/**
		 * Update Nova 3
		 */
		$this->app['router']->group(['prefix' => 'setup/update', 'before' => 'csrf'], function()
		{
			$this->app['router']->get('/', 'Nova\Setup\Controllers\Setup@getStart');
			$this->app['router']->get('finalize', 'Nova\Setup\Controllers\Update@getFinalize');
			$this->app['router']->get('rollback', 'Nova\Setup\Controllers\Update@getRollback');
			$this->app['router']->get('rollback/finalize', 'Nova\Setup\Controllers\Update@getRollbackFinalize');

			$this->app['router']->post('/', 'Nova\Setup\Controllers\Update@postIndex');
			$this->app['router']->post('rollback', 'Nova\Setup\Controllers\Update@postRollback');
		});

		/**
		 * Setup ajax calls
		 */
		$this->app['router']->group(['prefix' => 'setup/ajax', 'before' => 'csrf'], function()
		{
			$this->app['router']->post('ignore_version', 'Nova\Setup\Controllers\Ajax@postIgnoreVersion');
			$this->app['router']->post('install_genre', 'Nova\Setup\Controllers\Ajax@postInstallGenre');
			$this->app['router']->post('uninstall_genre', 'Nova\Setup\Controllers\Ajax@postUninstallGenre');
		});
	}

}