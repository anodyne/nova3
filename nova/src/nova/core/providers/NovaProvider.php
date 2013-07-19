<?php namespace Nova\Core\Providers;

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

	protected function browserCheck()
	{
		$this->app['events']->listen('nova.start', function()
		{
			//sd($this->app['nova.browser']);
		});
	}

}