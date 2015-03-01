<?php namespace Nova\Foundation\Providers;

use UserCreator,
	CharacterCreator;
use ReflectionClass;
use Illuminate\Support\ClassLoader,
	Illuminate\Support\ServiceProvider;
use League\CommonMark\CommonMarkConverter;
use Nova\Core\Pages\Services\Compilers\PageCompiler,
	Nova\Core\Settings\Services\Compilers\SettingCompiler;
use Nova\Foundation\Services\FlashNotifierService,
	Nova\Foundation\Services\MarkdownParserService,
	Nova\Foundation\Services\Locator\Locator,
	Nova\Foundation\Services\Themes\Theme as BaseTheme,
	Nova\Foundation\Services\Themes\MissingThemeImplementationException,
	Nova\Foundation\Services\PageCompiler\CompilerEngine,
	Nova\Foundation\Services\PageCompiler\Compilers\IconCompiler;

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
		$this->registerBindings();
		$this->getCurrentUser();
		$this->createLocator();
		$this->createPageCompilerEngine();

		if ($this->app['nova.setup']->isInstalled())
		{
			$this->setupTheme();
		}
	}

	/**
	 * Register any application services.
	 *
	 * @return	void
	 */
	public function register()
	{
		// Grab the aliases from the config
		$this->aliases = $this->app['config']['app.aliases'];

		if ($this->app->environment() == 'local')
		{
			if (class_exists('Barryvdh\Debugbar\ServiceProvider'))
			{
				$this->app->register('Barryvdh\Debugbar\ServiceProvider');
			}
		}
	}

	protected function createLocator()
	{
		$this->app->bind(
			['nova.locator' => 'Nova\Foundation\Services\Locator\LocatorInterface'],
			function($app)
			{
				return new Locator($app['nova.user'], $app['nova.settings']);
			}
		);

		// Add a search path in a service provider
		//$this->app['nova.locator']->registerSearchPath('extensions/Anodyne/Awards/views');
	}

	protected function createPageCompilerEngine()
	{
		$this->app->singleton('nova.page.compiler', function($app)
		{
			$engine = new CompilerEngine;

			$engine->registerCompiler('setting', new SettingCompiler);
			$engine->registerCompiler('page', new PageCompiler);
			$engine->registerCompiler('icon', new IconCompiler);

			return $engine;
		});

		// Add a page compiler in a service provider
		// $this->app['nova.page.compiler']->registerCompiler('foo', new Foo);
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
		$this->app->singleton('nova.settings', function($app)
		{
			if ($app['nova.setup']->isInstalled())
			{
				return $app['SettingRepository']->getAllSettings();
			}

			return false;
		});

		$this->app->bind('nova.character.creator', function($app)
		{
			return new CharacterCreator($app['CharacterRepository'], $app['events']);
		});

		$this->app->bind('nova.flash', function($app)
		{
			return new FlashNotifierService($app['session.store']);
		});

		$this->app->bind('nova.markdown', function($app)
		{
			return new MarkdownParserService(new CommonMarkConverter);
		});

		$this->app->bind('nova.user.creator', function($app)
		{
			return new UserCreator(
				$app['UserRepository'],
				$app['nova.character.creator'],
				$app['events']
			);
		});
	}

	protected function setRepositoryBindings()
	{
		// Build a list of repositories that should be built
		$bindings = ['Character', 'Page', 'PageContent', 'Setting', 'System',
			'User'];

		// Loop through the repositories and do the binding
		foreach ($bindings as $binding)
		{
			$this->bindRepository($binding);
		}
	}

	protected function setupTheme()
	{
		// Get the theme name
		$themeName = ($this->app['auth']->check())
			? $this->app['nova.user']->preference('theme')
			: $this->app['nova.settings']->theme;

		// Try to autoload the appropriate theme file
		ClassLoader::load($this->app->themePath($themeName).'/Theme.php');

		if (class_exists('Theme'))
		{
			// Make a new theme
			$theme = new \Theme($themeName, $this->app);

			// Get some information about this particular class
			$class = new ReflectionClass('Theme');
		}
		else
		{
			// Make a new base theme
			$theme = new BaseTheme($themeName, $this->app);

			// Get some information about this particular class
			$class = new ReflectionClass('Nova\Foundation\Services\Themes\Theme');
		}

		// Make sure that whatever class is handling theme that it implements
		// ALL of the necessary interfaces, otherwise throw an exception
		if ( ! $class->implementsInterface('Nova\Foundation\Services\Themes\Themeable') or
				! $class->implementsInterface('Nova\Foundation\Services\Themes\ThemeableInfo'))
		{
			throw new MissingThemeImplementationException;
		}

		// Bind the existing instance into the container
		$this->app->instance('nova.theme', $theme);
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
