<?php namespace Nova\Setup\Providers;

use Illuminate\Support\ServiceProvider;
use Nova\Setup\SetupService;
use Nova\Foundation\Services\FlashNotifierService,
	Nova\Foundation\Services\Locator\LocatorService;

class SetupServiceProvider extends ServiceProvider {

	protected $defer = true;

	public function boot()
	{
		//
	}

	public function register()
	{
		$this->createSetupService();
	}

	public function provides()
	{
		return ['nova.setup'];
	}

	protected function createSetupService()
	{
		$this->app->singleton('nova.setup', function($app)
		{
			return new SetupService($app);
		});
	}

}