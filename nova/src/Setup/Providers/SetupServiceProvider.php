<?php namespace Nova\Setup\Providers;

use Nova\Setup\SetupService;
use Illuminate\Support\ServiceProvider;

class SetupServiceProvider extends ServiceProvider {

	public function boot()
	{
		//
	}

	public function register()
	{
		$this->app->singleton('nova.setup', function($app)
		{
			return new SetupService($app);
		});
	}

}
