<?php namespace Nova\Core\Providers;

use Str;
use Nova\Core\Lib\Nova;
use Nova\Core\Lib\Media;
use Nova\Core\Lib\Location;
use Nova\Core\Lib\Markdown;
use Nova\Core\Lib\DynamicForm;
use Nova\Core\Lib\SystemEvent;
use dflydev\markdown\MarkdownParser;
use Illuminate\Support\ServiceProvider;

class NovaProvider extends ServiceProvider {

	public function register()
	{
		//
	}

	public function boot()
	{
		$this->bootEventListeners();
		$this->browserCheck();
	}

	protected function bootEventListeners()
	{
		// Get all the aliases
		$aliases = $this->app['config']->get('app.aliases');

		// Get the event config file
		$events = $this->app['config']->get('events');

		// Loop through the events
		foreach ($events as $event => $handlers)
		{
			// Make sure the handlers is an array
			$handlers = ( ! is_array($handlers)) ? array($handlers) : $handlers;

			// Loop through the handler classes and set the listeners
			foreach ($handlers as $h)
			{
				// Set the final class to use
				$finalHandler = (array_key_exists($h, $aliases)) ? $aliases[$h] : $h;

				// Listen to the event
				$this->app['events']->listen($event, $finalHandler);
			}
		}
	}

	protected function browserCheck()
	{
		$this->app['events']->listen('nova.start', function()
		{
			//sd($this->app['nova.browser']);
		});
	}

}