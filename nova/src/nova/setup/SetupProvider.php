<?php namespace Nova\Setup;

use Illuminate\Support\ServiceProvider;

class SetupProvider extends ServiceProvider {

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
		require SRCPATH.'setup/routes.php';

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
	}

}