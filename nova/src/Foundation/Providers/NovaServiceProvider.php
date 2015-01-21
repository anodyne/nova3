<?php namespace Nova\Foundation\Providers;

use Illuminate\Support\ServiceProvider;
use League\CommonMark\CommonMarkConverter;
use Nova\Foundation\Services\FlashNotifierService,
	Nova\Foundation\Services\MarkdownParserService,
	Nova\Foundation\Services\Locator\LocatorService;
use Nova\Foundation\Services\PageCompiler\CompilerEngine,
	Nova\Foundation\Services\PageCompiler\Compilers\SettingCompiler;

class NovaServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return	void
	 */
	public function boot()
	{
		$this->setRepositoryBindings();
		$this->getCurrentUser();
		$this->createLocator();
		$this->createMarkdownParser();
		$this->createFlashNotifier();
		$this->createPageCompilerEngine();
	}

	/**
	 * Register any application services.
	 *
	 * @return	void
	 */
	public function register()
	{
		//
	}

	protected function setRepositoryBindings()
	{
		// Grab the aliases from the config
		$alias = $this->app['config']['app.aliases'];

		$this->app->bind($alias['PageRepositoryInterface'], $alias['PageRepository']);
		$this->app->bind($alias['SystemRepositoryInterface'], $alias['SystemRepository']);
	}

	protected function createFlashNotifier()
	{
		$this->app->singleton('nova.flash', function($app)
		{
			return new FlashNotifierService($app['session.store']);
		});
	}

	protected function createLocator()
	{
		$this->app->singleton('nova.locator', function($app)
		{
			return new LocatorService($app['nova.user']);
			//return new LocatorService($app['nova.user'], $app->make('SettingsRepository'));
		});
	}

	protected function createMarkdownParser()
	{
		$this->app->singleton('nova.markdown', function($app)
		{
			return new MarkdownParserService(new CommonMarkConverter);
		});
	}

	protected function createPageCompilerEngine()
	{
		$this->app->singleton('nova.page.compiler.setting', function($app)
		{
			return new SettingCompiler;
		});

		$this->app->singleton('nova.page.compiler', function($app)
		{
			$engine = new CompilerEngine;
			$engine->registerCompiler('setting', $app['nova.page.compiler.setting']);

			return $engine;
		});

		// Add a page parser handler in a service provider
		// $this->app['nova.page.compiler']->registerCompiler('foo', new Foo);
		// app('nova.page.compiler')->registerCompiler('foo', new Foo);
		// app('nova.page.compiler')->registerCompiler('foo', function($matches){ return $matches; });
	}

	protected function getCurrentUser()
	{
		$this->app->singleton('nova.user', function($app)
		{
			return $app['auth']->user();
		});
	}

}
