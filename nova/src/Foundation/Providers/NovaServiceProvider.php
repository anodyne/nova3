<?php namespace Nova\Foundation\Providers;

use UserCreator,
	CharacterCreator;
use ReflectionClass;
use Illuminate\Support\Collection,
	Illuminate\Support\ClassLoader,
	Illuminate\Support\ServiceProvider;
use League\CommonMark\CommonMarkConverter;
use Nova\Core\Forms\Services\Compilers\FormCompiler,
	Nova\Core\Pages\Services\Compilers\PageCompiler,
	Nova\Core\Settings\Services\Compilers\SettingCompiler,
	Nova\Core\Pages\Services\Compilers\PageContentCompiler;
use Nova\Foundation\Services\FlashNotifier,
	Nova\Foundation\Services\MarkdownParser,
	Nova\Foundation\Services\Locator\Locator,
	Nova\Foundation\Services\Themes\Theme as BaseTheme,
	Nova\Foundation\Services\Themes\MissingThemeImplementationException,
	Nova\Foundation\Services\PageCompiler\CompilerEngine,
	Nova\Foundation\Services\PageCompiler\Compilers\IconCompiler;

class NovaServiceProvider extends ServiceProvider {

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
			$this->setupMailer();
		}
	}

	/**
	 * Register any application services.
	 *
	 * @return	void
	 */
	public function register()
	{
		if ($this->app['env'] == 'local')
		{
			if (class_exists('Barryvdh\Debugbar\ServiceProvider'))
			{
				$this->app->register('Barryvdh\Debugbar\ServiceProvider');
			}
		}
	}

	/**
	 * Build the locator that's at the heart-and-soul of seamless substitution.
	 * Developers can add additional locations to search by calling the
	 * registerSearchPath method on the nova.locator class in the IOC. Adding
	 * a search path will insert it in the center of the search stack.
	 */
	protected function createLocator()
	{
		$this->app->singleton(
			['nova.locator' => 'Nova\Foundation\Services\Locator\Locatable'],
			function($app)
			{
				return new Locator($app['nova.user'], $app['nova.settings']);
			}
		);

		// Add a search path in a service provider
		//$this->app['nova.locator']->registerSearchPath('extensions/Anodyne/Awards/views');
	}

	/**
	 * Build the page compiler engine and add some of the compilers we want to
	 * have out of the box. Developers can add additional compilers from their
	 * service providers by calling the registerCompiler method on the
	 * nova.page.compiler class in the IOC.
	 */
	protected function createPageCompilerEngine()
	{
		$this->app->singleton('nova.page.compiler', function($app)
		{
			$engine = new CompilerEngine;

			$engine->registerCompiler('page', new PageCompiler);
			$engine->registerCompiler('content', new PageContentCompiler);
			$engine->registerCompiler('icon', new IconCompiler);
			$engine->registerCompiler('form', new FormCompiler);

			return $engine;
		});

		// Add a page compiler in a service provider
		// $this->app['nova.page.compiler']->registerCompiler('foo', new Foo);
	}

	/**
	 * Get the current user out of the Auth class so we have quick and easy
	 * access to it instead of having to rely on calling Auth::user every time
	 * we want the current user. This also has the added benefit of being far
	 * more flexible in the event we change how the user is handled.
	 */
	protected function getCurrentUser()
	{
		$this->app->singleton('nova.user', function($app)
		{
			if ($app['nova.setup']->isInstalled()) return $app['auth']->user();

			return null;
		});
	}

	/**
	 * This registers all of the bindings with the IOC that Nova uses all over
	 * the place. Developers can easily override any of these in their own
	 * service providers.
	 */
	protected function registerBindings()
	{
		$this->app->singleton('nova.pageContent', function($app)
		{
			if ($app['nova.setup']->isInstalled())
			{
				return $app['PageContentRepository']->getAllContent();
			}

			return new Collection;
		});

		$this->app->singleton('nova.settings', function($app)
		{
			if ($app['nova.setup']->isInstalled())
			{
				return $app['SettingRepository']->getAllSettings();
			}

			return new Collection;
		});

		$this->app->bind('nova.character.creator', function($app)
		{
			return new CharacterCreator($app['CharacterRepository'], $app['events']);
		});

		$this->app->bind('nova.flash', function($app)
		{
			return new FlashNotifier;
		});

		$this->app->bind('nova.markdown', function($app)
		{
			return new MarkdownParser(new CommonMarkConverter);
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

	/**
	 * Bind all of the repository interfaces to their appropriate concrete
	 * class and make sure we alias them at the same time. This allows for
	 * quick and easy use of the repositories out of the IOC.
	 */
	protected function setRepositoryBindings()
	{
		// Build a list of repositories that should be built
		$bindings = ['Character', 'Menu', 'MenuItem', 'NovaForm', 'NovaFormField',
			'NovaFormFieldValue', 'NovaFormSection', 'NovaFormTab', 'Page',
			'PageContent', 'Permission', 'Role', 'Setting', 'System', 'User'];

		// Loop through the repositories and do the binding
		foreach ($bindings as $binding)
		{
			$this->bindRepository($binding);
		}
	}

	/**
	 * Set the mailer's default from address and name to the values stored in
	 * the settings table. This allows admins to change the defaults without
	 * having to edit any PHP files.
	 */
	protected function setupMailer()
	{
		config(['mail.from.address' => $this->app['nova.settings']->get('mail_default_address')]);
		config(['mail.from.name' => $this->app['nova.settings']->get('mail_default_name')]);
	}

	/**
	 * Setup the theme class that will handle all of the rendering of the theme.
	 * In some cases, the theme could have its own class to override what the
	 * core is doing, and if it does, we need to make sure it implements the
	 * necessary interfaces. Otherwise, we'll just fallback to the base theme
	 * class in the core.
	 */
	protected function setupTheme()
	{
		// Get the theme name
		$themeName = ($this->app['auth']->check())
			? $this->app['nova.user']->preference('theme')
			: $this->app['nova.settings']->get('theme');

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
		$this->app->bind([$abstract => alias($abstract)], alias($concrete));
	}

}
