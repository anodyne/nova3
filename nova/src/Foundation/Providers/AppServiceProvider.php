<?php namespace Nova\Foundation\Providers;

use Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	public function boot()
	{
		Schema::defaultStringLength(191);

		$this->registerTranslator();
		$this->registerFlashNotifier();
	}

	public function register()
	{
		if ($this->app['env'] == 'local') {
			if (class_exists('Barryvdh\Debugbar\ServiceProvider')) {
				$this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
			}
		}
	}

	protected function registerFlashNotifier()
	{
		$this->app->singleton('nova.flash', function ($app) {
			return new \Nova\Foundation\FlashNotifier($app['session']);
		});
	}

	protected function registerTranslator()
	{
		// Figure out what language we need
		$lang = $this->app['config']->get('app.locale');

		// Grab the full list of language items
		$this->app->singleton('nova.translator.loader', function ($app) {
			return new \Nova\Foundation\TranslationFileLoader(
				$app['files'],
				$app['path.lang'],
				$app['path.nova.lang']
			);
		});

		$this->app->singleton('nova.translator.messages', function ($app) use ($lang) {
			return $app['nova.translator.loader']->load($lang, '*', '*');
		});

		// Create a new instance of the translator
		$translator = new \Krinkle\Intuition\Intuition([
			'globalfunctions' => false,
			'stayalive' => true,
			'suppressfatal' => false,
			'suppressnotice' => false,
		]);

		// Set the messages from the loaded file(s)
		$translator->setMsgs($this->app['nova.translator.messages']);

		// Bind the translator instance into the container
		$this->app->instance('nova.translator', $translator);
	}
}
