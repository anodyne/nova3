<?php namespace Nova\Foundation\Providers;

use Illuminate\Support\ServiceProvider;

class DeferredServiceProvider extends ServiceProvider
{
	protected $defer = true;

	public function register()
	{
		$this->app->bind('nova.configWriter', function ($app) {
			return new \Nova\Setup\ConfigFileWriter($app['files']);
		});

		$this->app->bind('browser', function ($app) {
			return new \Nova\Foundation\Services\Browser(new \Ikimea\Browser\Browser);
		});

		$this->app->bind('nova.characterCreator', function ($app) {
			return new \CharacterCreator($app['CharacterRepository']);
		});

		$this->app->bind('nova.userCreator', function ($app) {
			return new \UserCreator(
				$app['UserRepository'],
				$app['nova.characterCreator']
			);
		});

		$this->app->bind('nova.flash', function ($app) {
			return new \Nova\Foundation\Services\FlashNotifier;
		});

		$this->app->bind('nova.markdown', function ($app) {
			return new \Nova\Foundation\Services\MarkdownParser(
				new \League\CommonMark\CommonMarkConverter
			);
		});

		$this->app->register(\Spatie\Backup\BackupServiceProvider::class);
	}

	public function provides()
	{
		return [
			'browser',
			'nova.configWriter',
			'nova.characterCreator',
			'nova.userCreator',
			'nova.flash',
			'nova.markdown'
		];
	}
}
