<?php namespace Nova\Setup\Providers;

use Illuminate\Support\ServiceProvider;
use Nova\Setup\Services\SetupService,
	Nova\Setup\Services\ConfigFileWriterService;

class SetupServiceProvider extends ServiceProvider {

	protected $defer = true;

	public function register()
	{
		$this->app->singleton('nova.setup', function($app)
		{
			return new SetupService($app);
		});

		$this->app->singleton('nova.setup.configWriter', function($app)
		{
			return new ConfigFileWriterService($app['files']);
		});
	}

	public function provides()
	{
		return [
			'nova.setup',
			'nova.setup.configWriter',
		];
	}

}
