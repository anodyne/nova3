<?php namespace Nova\Core\Providers;

use Nova\Core\Lib\Nova;
use Nova\Core\Lib\Media;
use Ikimea\Browser\Browser;
use Nova\Core\Lib\Location;
use Nova\Core\Lib\Markdown;
use Nova\Core\Lib\DynamicForm;
use Nova\Core\Lib\SystemEvent;
use dflydev\markdown\MarkdownParser;
use Illuminate\Support\ServiceProvider;

class NovaServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->setupBindings();
		
		$this->registerLocation();
		$this->registerMarkdown();
		$this->registerSystemEvent();
		$this->registerCommon();
		$this->registerMedia();
		$this->registerDynamicForm();
		$this->registerBrowser();
	}

	public function boot()
	{
		$this->bootEventListeners();
		$this->browserCheck();
	}

	/**
	 * The Location class provides a way to find files within the file system.
	 */
	protected function registerLocation()
	{
		$this->app['nova.location'] = $this->app->share(function($app)
		{
			return new Location;
		});
	}

	/**
	 * The Markdown class provides for parsing Markdown content to HTML.
	 */
	protected function registerMarkdown()
	{
		$this->app['markdown'] = $this->app->share(function($app)
		{
			return new Markdown(new MarkdownParser);
		});
	}

	/**
	 * The System Event classes provides system event logging to a database
	 * table so that admins can see what kinds of actions are being taken within
	 * Nova.
	 */
	protected function registerSystemEvent()
	{
		$this->app['nova.event'] = $this->app->share(function($app)
		{
			return new SystemEvent;
		});
	}

	/**
	 * Common classes are the methods that don't belong in other classes and are
	 * used throughout Nova.
	 */
	protected function registerCommon()
	{
		$this->app['nova.common'] = $this->app->share(function($app)
		{
			return new Nova;
		});
	}

	/**
	 * The Media class provides methods for uploading, deleting and retrieving
	 * information about media.
	 */
	protected function registerMedia()
	{
		$this->app['nova.media'] = $this->app->share(function($app)
		{
			return new Media;
		});
	}

	/**
	 * The Dynamic Form class provides a way to interact with Nova's dynamic
	 * forms including rendering the form and filling its data.
	 */
	protected function registerDynamicForm()
	{
		$this->app['nova.form'] = $this->app->share(function($app)
		{
			return new DynamicForm;
		});
	}

	/**
	 * The Browser class provides a way to get information about the current
	 * user's browser.
	 */
	protected function registerBrowser()
	{
		$this->app['nova.browser'] = $this->app->share(function($app)
		{
			return new Browser;
		});
	}

	/**
	 * During the nova.start event, check to make sure that a user is using one
	 * of the approved browsers.
	 */
	protected function browserCheck()
	{
		$this->app['events']->listen('nova.start', function()
		{
			//sd($this->app['nova.browser']);
		});
	}

	/**
	 * Grab the events config file and loop through the items to create the
	 * event listeners for all of Nova's events.
	 */
	protected function bootEventListeners()
	{
		// Get all the aliases
		$aliases = $this->app['config']->get('app.aliases');

		// Get the event config file
		$events = $this->app['config']->get('events');

		foreach ($events as $event => $handlers)
		{
			// Make sure the handlers is an array
			$handlers = ( ! is_array($handlers)) ? array($handlers) : $handlers;

			foreach ($handlers as $h)
			{
				// Set the final class to use
				$finalHandler = (array_key_exists($h, $aliases)) ? $aliases[$h] : $h;

				// Listen for the event
				$this->app['events']->listen($event, $finalHandler);
			}
		}
	}

	/**
	 * Setup the interface bindings to their repositories.
	 */
	protected function setupBindings()
	{
		// Get the aliases
		$a = $this->app['config']->get('app.aliases');

		/**
		 * Repository interface bindings
		 */
		$this->app->bind($a['AccessRoleRepositoryInterface'], $a['AccessRoleRepository']);
		$this->app->bind($a['CatalogRepositoryInterface'], $a['CatalogRepository']);
		$this->app->bind($a['FormRepositoryInterface'], $a['FormRepository']);
		$this->app->bind($a['SettingsRepositoryInterface'], $a['SettingsRepository']);
		$this->app->bind($a['SiteContentRepositoryInterface'], $a['SiteContentRepository']);
		$this->app->bind($a['SystemRouteRepositoryInterface'], $a['SystemRouteRepository']);
		$this->app->bind($a['UserRepositoryInterface'], $a['UserRepository']);

		/**
		 * Other interface bindings
		 */
		$this->app->bind($a['NovaAuthInterface'], $a['NovaAuth']);
	}

}