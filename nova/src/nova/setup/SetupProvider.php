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
		$this->app->singleton('nova.setup', function()
		{
			return new Setup;
		});
	}

}