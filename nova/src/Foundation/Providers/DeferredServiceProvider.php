<?php namespace Nova\Foundation\Providers;

use Illuminate\Support\ServiceProvider;

class DeferredServiceProvider extends ServiceProvider
{
	protected $defer = true;

	public function register()
	{
		$this->app->singleton('nova.flash', function ($app) {
			return new \Nova\Foundation\FlashNotifier($app['session']);
		});

		$this->app->singleton('nova.markdown', function ($app) {
			return new \Nova\Foundation\MarkdownParser(new \Parsedown);
		});

		$this->app->singleton('nova.settings', function ($app) {
			return (object)cache()->get('nova.settings', collect());
		});

		$this->app->singleton('nova2.migrator', function ($app) {
			return new \Nova\Setup\Migrations\MigrationManager;
		});
	}

	public function provides()
	{
		return [
			'nova.flash',
			'nova.markdown',
			'nova.settings',
			'nova2.migrator',
		];
	}
}
