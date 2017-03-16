<?php namespace Nova\Foundation\Providers;

use ReflectionClass;
use Illuminate\Support\ServiceProvider;
use Nova\Foundation\Themes\Theme as BaseTheme,
	Nova\Foundation\Themes\Exceptions\MissingThemeImplementationException;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return	void
	 */
	public function boot()
	{
		$this->app->singleton('nova', function ($app) {
			return new \Nova\Foundation\Nova;
		});

		$this->setRepositoryBindings();
		$this->registerBindings();
		$this->getCurrentUser();
		$this->createLocator();
		$this->createPageCompilerEngine();
		$this->createFieldTypesManager();
		$this->registerTranslator();
		$this->setupTheme();
		$this->setupEmojiOne();

		if ($this->app['nova']->isInstalled()) {
			$this->setupMailer();
			
			$this->app['nova']->startup();
		}
	}

	/**
	 * Register any application services.
	 *
	 * @return	void
	 */
	public function register()
	{
		if ($this->app['env'] == 'local') {
			if (class_exists('Barryvdh\Debugbar\ServiceProvider')) {
				$this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
			}
		}

		if ($this->app['env'] == 'local' or $this->app['env'] == 'testing') {
			if (class_exists('Laravel\Dusk\DuskServiceProvider')) {
				$this->app->register(\Laravel\Dusk\DuskServiceProvider::class);
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
		$this->app->singleton('Nova\Foundation\Services\Locator\Locatable', function ($app) {
			return new \Nova\Foundation\Services\Locator\Locator(
				$app['nova.user'],
				$app['nova.settings']
			);
		});

		$this->app->alias('Nova\Foundation\Services\Locator\Locatable', 'nova.locator');

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
		$this->app->singleton('nova.page.compiler', function ($app) {
			$engine = new \Nova\Foundation\Services\PageCompiler\CompilerEngine;

			$engine->registerCompiler('page',
				new \Nova\Core\Pages\Services\Compilers\PageCompiler
			);
			$engine->registerCompiler('content',
				new \Nova\Core\Pages\Services\Compilers\PageContentCompiler
			);
			$engine->registerCompiler('icon',
				new \Nova\Foundation\Services\PageCompiler\Compilers\IconCompiler
			);
			$engine->registerCompiler('form',
				new \Nova\Core\Forms\Services\Compilers\FormCompiler
			);

			return $engine;
		});

		// Add a page compiler in a service provider
		// $this->app['nova.page.compiler']->registerCompiler('foo', new Foo);
	}

	protected function createFieldTypesManager()
	{
		$this->app->singleton('nova.forms.fields', function ($app) {
			$manager = new \Nova\Core\Forms\Services\FieldTypes\FieldTypeManager;

			$manager->registerFieldType('text-field',
				new \Nova\Core\Forms\Services\FieldTypes\TextField
			);
			$manager->registerFieldType('text-block',
				new \Nova\Core\Forms\Services\FieldTypes\TextBlock
			);
			$manager->registerFieldType('text-editor',
				new \Nova\Core\Forms\Services\FieldTypes\TextEditor
			);
			$manager->registerFieldType('dropdown',
				new \Nova\Core\Forms\Services\FieldTypes\Dropdown
			);
			$manager->registerFieldType('radio',
				new \Nova\Core\Forms\Services\FieldTypes\RadioButton
			);

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
		$this->app->singleton('nova.user', function ($app) {
			if (nova()->isInstalled()) {
				$user = $app['auth']->user();

				if ($user) {
					$user->load('userPreferences', 'unreadNotifications');
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
		$this->app->singleton('nova.pages', function ($app) {
			if (nova()->isInstalled()) {
				return $app['PageRepository']->all();
			}

			return collect();
		});

		$this->app->singleton('nova.pageContent', function ($app) {
			if (nova()->isInstalled()) {
				return $app['PageContentRepository']->getAllContent();
			}

			return collect();
		});

		$this->app->singleton('nova.settings', function ($app) {
			if (nova()->isInstalled()) {
				return $app['SettingRepository']->getAllSettings();
			}

			return collect();
		});

		$this->app->singleton('nova.system', function ($app) {
			if (nova()->isInstalled()) {
				return $app['SystemRepository']->getAllInfo();
			}

			return collect();
		});

		$this->app->singleton('nova.hooks', function ($app) {
			return new \Nova\Foundation\HookManager;
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
		foreach ($bindings as $binding) {
			// Set the concrete and abstract names
			$abstract = "{$binding}RepositoryContract";
			$abstractFQN = alias($abstract);
			$concrete = alias("{$binding}Repository");

			// Bind to the container and set the alias
			$this->app->bind($abstractFQN, $concrete);
			$this->app->alias($abstractFQN, $abstract);
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
	 * necessary contracts. Otherwise, we'll just fallback to the base theme
	 * class in the core.
	 */
	protected function setupTheme()
	{
		$themeName = 'pulsar';

		if ($this->app['nova']->isInstalled()) {
			// Get the theme name
			$themeName = ($this->app['auth']->check())
				? $this->app['nova.user']->preference('theme')
				: $this->app['nova.settings']->get('theme');
		}

		// Try to autoload the appropriate theme file
		if (file_exists($this->app->themePath($themeName).'\\Theme.php')) {
			spl_autoload_register(function ($class) use ($themeName) {
				include app()->themePath($themeName).'\\Theme.php';
			});

			// Make a new theme
			$theme = new \Theme($themeName, $this->app, $this->app['nova.locator']);

			// Get some information about this particular class
			$class = new ReflectionClass('Theme');
		} else {
			// Make a new base theme
			$theme = new BaseTheme($themeName, $this->app, $this->app['nova.locator']);

			// Get some information about this particular class
			$class = new ReflectionClass('Nova\Foundation\Themes\Theme');
		}

		// Make sure that whatever class is handling the theme that it implements
		// ALL of the necessary contracts, otherwise throw an exception
		$unimplementedContracts = array_diff([
			'Nova\Foundation\Themes\ThemeIconsContract',
			'Nova\Foundation\Themes\ThemeInfoContract',
			'Nova\Foundation\Themes\ThemeMenusContract',
			'Nova\Foundation\Themes\ThemeStructureContract',
		], $class->getInterfaceNames());

		if (count($unimplementedContracts) > 0) {
			throw new MissingThemeImplementationException;
		}

		// Bind the existing instance into the container
		$this->app->instance('nova.theme', $theme);
	}

	protected function setupEmojiOne()
	{
		$client = new \Emojione\Client(new \Emojione\Ruleset);
		$client->imageType = 'svg';
		$client->imagePathSVG = nova_path('resources/emoji');

		$this->app->instance('emoji', $client);
	}

	protected function registerTranslator()
	{
		// Figure out what language we need
		$lang = 'en';

		// Grab the full list of language items
		$this->app->singleton('nova.translator.loader', function ($app) {
			return new \Nova\Foundation\TranslationFileLoader(
				$app['files'],
				$app['path.lang'],
				$app['path.nova.lang'],
				$app['path.extension']
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
