<?php namespace Nova\Foundation\Providers;

use Nova\Users\UserCreator;
use Illuminate\Support\ServiceProvider;

class DeferredServiceProvider extends ServiceProvider
{
	protected $defer = true;

	public function register()
	{
		$this->app->singleton('nova.flash', function ($app) {
			return new \Nova\Foundation\FlashNotifier($app['session']);
		});
	}

	public function provides()
	{
		return [
			'nova.flash'
		];
	}
}
