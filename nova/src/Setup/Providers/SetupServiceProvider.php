<?php namespace Nova\Setup\Providers;

use Illuminate\Support\ServiceProvider;

class SetupServiceProvider extends ServiceProvider {

	public $defer = true;

	public function register()
	{
		$this->app->singleton('nova.setup.configWriter', function ($app)
		{
			return new \Nova\Setup\ConfigFileWriter($app['files']);
		});

		$this->app->register(\Spatie\Backup\BackupServiceProvider::class);
	}

	public function provides()
	{
		return ['nova.setup.configWriter'];
	}
}
