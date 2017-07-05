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

		$this->creators();
	}

	protected function creators()
	{
		$this->app->bind(\Nova\Users\UserCreator::class, function ($app) {
			return new \Nova\Users\UserCreator($app['UserRepository']);
		});
	}

	public function provides()
	{
		return [
			'nova.flash',

			\Nova\Users\UserCreator::class,
		];
	}
}
