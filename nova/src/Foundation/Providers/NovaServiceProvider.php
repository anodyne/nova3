<?php namespace Nova\Foundation\Providers;

use UserCreator,
	CharacterCreator;
use ReflectionClass;
use Illuminate\Support\ClassLoader,
	Illuminate\Support\ServiceProvider;
use League\CommonMark\CommonMarkConverter;
use Nova\Foundation\Services\FlashNotifierService,
	Nova\Foundation\Services\MarkdownParserService,
	Nova\Foundation\Services\Locator\LocatorService,
	Nova\Foundation\Services\Themes\Theme as BaseTheme,
	Nova\Foundation\Services\Themes\MissingThemeImplementationException;;
use Nova\Foundation\Services\PageCompiler\CompilerEngine,
	Nova\Foundation\Services\PageCompiler\Compilers\SettingCompiler;

class NovaServiceProvider extends ServiceProvider {

	protected $aliases;

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
		$this->createPageCompilerEngine();
		$this->registerBindings();
		$this->setupTheme();
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

	protected function createLocator()
	{
		$this->app->singleton('nova.locator', function($app)
		{
			return new LocatorService($app['nova.user']);
			//return new LocatorService($app['nova.user'], $app->make('SettingsRepository'));
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

	protected function registerBindings()
	{
		$this->app->bind('nova.character.creator', function($app)
		{
			return new CharacterCreator(
				$app['CharacterRepositoryInterface'],
				$app['events']
			);
		});

		$this->app->singleton('nova.flash', function($app)
		{
			return new FlashNotifierService($app['session.store']);
		});

		$this->app->singleton('nova.markdown', function($app)
		{
			return new MarkdownParserService(new CommonMarkConverter);
		});

		$this->app->bind('nova.user.creator', function($app)
		{
			return new UserCreator(
				$app['UserRepositoryInterface'],
				$app['nova.character.creator'],
				$app['events']
			);
		});
	}

	protected function setRepositoryBindings()
	{
		// Grab the aliases from the config
		$this->aliases = $this->app['config']['app.aliases'];

		// Set the items being bound
		$bindings = ['Character', 'Page', 'System', 'User'];

		foreach ($bindings as $binding)
		{
			$this->bindRepository($binding);
		}
	}

	protected function setupTheme()
	{
		# TODO: pull the default theme out of the database if we need it
		// Get the theme name
		$themeName = ($this->app['auth']->check())
			? $this->app['nova.user']->getPreference('theme')
			: 'pulsar';

		// Autoload the appropriate theme directory
		//ClassLoader::addDirectories([$this->app->themePath($themeName)]);
		ClassLoader::load($this->app->themePath($themeName).'/Theme.php');

		// Does the user's theme have a theme file?
		$theme = (class_exists('Theme')) 
			? new \Theme($themeName, $this->app) 
			: new BaseTheme($themeName, $this->app);

		// The interfaces the class must implement
		$mustImplement = [
			'Nova\Foundation\Services\Themes\Themeable',
			'Nova\Foundation\Services\Themes\ThemeableInfo'
		];

		// The final class has to implment both interfaces or we need to throw an exception
		if (count(array_intersect($mustImplement, class_implements($theme))) < 2)
		{
			throw new MissingThemeImplementationException;
		}

		$this->app->bind('nova.theme', function($app) use ($theme)
		{
			return $theme;
		});
	}

	private function bindRepository($item)
	{
		// Set the concrete and abstract names
		$abstract = "{$item}RepositoryInterface";
		$concrete = "{$item}Repository";

		// Bind to the container
		$this->app->bind(
			[$abstract => $this->aliases[$abstract]], 
			$this->aliases[$concrete]
		);
	}

}
