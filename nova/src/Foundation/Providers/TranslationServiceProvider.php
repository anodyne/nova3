<?php namespace Nova\Foundation\Providers;

use Illuminate\Translation\TranslationServiceProvider as ServiceProvider;

class TranslationServiceProvider extends ServiceProvider {

	protected function registerLoader()
	{
		$this->app->singleton('translation.loader', function ($app) {
			return new \Nova\Foundation\Translation\FileLoader(
				$app['files'],
				$app['path.lang'],
				$app['path.coreLang']
			);
		});
	}
}
