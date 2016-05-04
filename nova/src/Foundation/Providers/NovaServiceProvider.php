<?php namespace Nova\Foundation\Providers;

use UserCreator,
	CharacterCreator;
use ReflectionClass;
use Illuminate\Support\ClassLoader,
	Illuminate\Support\ServiceProvider;
use League\CommonMark\CommonMarkConverter;
use Nova\Core\Forms\Services\FieldTypes,
	Nova\Core\Forms\Services\Compilers\FormCompiler,
	Nova\Core\Pages\Services\Compilers\PageCompiler,
	Nova\Core\Settings\Services\Compilers\SettingCompiler,
	Nova\Core\Pages\Services\Compilers\PageContentCompiler;
use Nova\Foundation\Themes\Theme as BaseTheme,
	Nova\Foundation\Themes\Exceptions\MissingThemeImplementationException;
use Nova\Foundation\Nova,
	Nova\Foundation\Services\FlashNotifier,
	Nova\Foundation\Services\MarkdownParser,
	Nova\Foundation\Services\Locator\Locator,
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
		$this->createFieldTypesManager();
		$this->setupTheme();
		$this->setupMailer();

		$this->app->singleton('nova', function ($app)
		{
			return new Nova;
		});
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
			function ($app)
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
		$this->app->singleton('nova.page.compiler', function ($app)
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

	protected function createFieldTypesManager()
	{
		$this->app->singleton('nova.forms.fields', function ($app)
		{
			$manager = new FieldTypes\FieldTypeManager;

			$manager->registerFieldType('text', new FieldTypes\TextField);
			$manager->registerFieldType('textarea', new FieldTypes\TextBlock);
			$manager->registerFieldType('select', new FieldTypes\Dropdown);
			$manager->registerFieldType('radio', new FieldTypes\RadioButton);

			return $manager;
		});

		// Add a field type in a service provider
		// $this->app['nova.forms.fields']->registerFieldType('alias', new Concrete);
	}

	/**
	 * Get the current user out of the Auth class so we have quick and easy
	 * access to it instead of having to rely on calling Auth::user every time
	 * we want the current user. This also has the added benefit of being far
	 * more flexible in the event we change how the user is handled.
	 */
	protected function getCurrentUser()
	{
		$this->app->singleton('nova.user', function ($app)
		{
			if ($app['nova.setup']->isInstalled())
			{
				$user = $app['auth']->user();

				if ($user)
				{
					$user->load('userPreferences');
				}

				return $user;
			}

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
		$this->app->singleton('nova.pages', function ($app)
		{
			if ($app['nova.setup']->isInstalled())
			{
				return $app['PageRepository']->all();
			}

			return collect();
		});

		$this->app->singleton('nova.pageContent', function ($app)
		{
			if ($app['nova.setup']->isInstalled())
			{
				return $app['PageContentRepository']->getAllContent();
			}

			return collect();
		});

		$this->app->singleton('nova.settings', function ($app)
		{
			if ($app['nova.setup']->isInstalled())
			{
				return $app['SettingRepository']->getAllSettings();
			}

			return collect();
		});

		$this->app->bind('nova.character.creator', function ($app)
		{
			return new CharacterCreator($app['CharacterRepository'], $app['events']);
		});

		$this->app->bind('nova.flash', function ($app)
		{
			return new FlashNotifier;
		});

		$this->app->bind('nova.markdown', function ($app)
		{
			return new MarkdownParser(new CommonMarkConverter);
		});

		$this->app->bind('nova.user.creator', function ($app)
		{
			return new UserCreator(
				$app['UserRepository'],
				$app['nova.character.creator'],
				$app['events']
			);
		});
	}

	/**
	 * Bind all of the repository contracts to their appropriate concrete
	 * class and make sure we alias them at the same time. This allows for
	 * quick and easy use of the repositories out of the IOC.
	 */
	protected function setRepositoryBindings()
	{
		// Build a list of repositories that should be built
		$bindings = [
			'Character',
			'Menu', 'MenuItem',
			'Form', 'FormField', 'FormSection', 'FormTab', 'FormEntry', 'FormData',
			'Page', 'PageContent',
			'Permission', 'Role',
			'Setting', 'System',
			'User', 'UserPreference', 'PreferenceDefault',
		];

		// Loop through the repositories and do the binding
		foreach ($bindings as $binding)
		{
			// Set the concrete and abstract names
			$abstract = "{$binding}RepositoryContract";
			$concrete = "{$binding}Repository";

			// Bind to the container
			$this->app->bind([$abstract => alias($abstract)], alias($concrete));
		}
	}

	/**
	 * Set the mailer's default from address and name to the values stored in
	 * the settings table. This allows admins to change the defaults without
	 * having to edit any PHP files.
	 */
	protected function setupMailer()
	{
		if ($this->app['nova.setup']->isInstalled())
		{
			config(['mail.from.address' => $this->app['nova.settings']->get('mail_default_address')]);
			config(['mail.from.name' => $this->app['nova.settings']->get('mail_default_name')]);
		}
	}

	/**
	 * Setup the theme class that will handle all of the rendering of the theme.
	 * In some cases, the theme could have its own class to override what the
	 * core is doing, and if it does, we need to make sure it implements the
	 * necessary contracts. Otherwise, we'll just fallback to the base theme
	 * class in the core.
	 */
	protected function setupTheme()
	{
		if ($this->app['nova.setup']->isInstalled())
		{
			// Get the theme name
			$themeName = ($this->app['auth']->check())
				? $this->app['nova.user']->preference('theme')
				: $this->app['nova.settings']->get('theme');
		}
		else
		{
			$themeName = "pulsar";
		}

		// Try to autoload the appropriate theme file
		ClassLoader::addDirectories($this->app->themePath($themeName));
		$loaded = ClassLoader::load('Theme');

		if (class_exists('Theme'))
		{
			// Make a new theme
			$theme = new \Theme($themeName, $this->app, $this->app['nova.locator']);

			// Get some information about this particular class
			$class = new ReflectionClass('Theme');
		}
		else
		{
			// Make a new base theme
			$theme = new BaseTheme($themeName, $this->app, $this->app['nova.locator']);

			// Get some information about this particular class
			$class = new ReflectionClass('Nova\Foundation\Themes\Theme');
		}

		// Make sure that whatever class is handling the theme that it implements
		// ALL of the necessary contracts, otherwise throw an exception
		$contractsToImplement = [
			'Nova\Foundation\Themes\ThemeIconsContract',
			'Nova\Foundation\Themes\ThemeInfoContract',
			'Nova\Foundation\Themes\ThemeMenusContract',
			'Nova\Foundation\Themes\ThemeStructureContract',
		];

		foreach ($contractsToImplement as $contract)
		{
			if ( ! $class->implementsInterface($contract))
			{
				throw new MissingThemeImplementationException;
			}
		}

		// Bind the existing instance into the container
		$this->app->instance('nova.theme', $theme);
	}

}
