<?php namespace Nova\Setup;

use Illuminate\Support\ServiceProvider;

class SetupProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerSetup();
	}

	protected function registerSetup()
	{
		$this->app['nova.setup'] = $this->app->share(function($app)
		{
			return new Setup;
		});
	}

}