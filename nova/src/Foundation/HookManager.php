<?php namespace Nova\Foundation;

class HookManager
{
	protected $hooks = [];

	/**
	 * Register a hook for a named route with a callback.
	 *
	 * @param 	$routeName
	 * @param 	$callback
	 * @return 	$this
	 */
	public function register($routeName, $callback)
	{
		$this->hooks[$routeName][] = $callback;

		return $this;
	}

	/**
	 * Run all the hooks for a named route with its callback(s).
	 *
	 * @param 	$routeName
	 * @return 	$this
	 */
	public function run($routeName)
	{
		// See if we have a hook for this route
		$routeCallbacks = (array_key_exists($routeName, $this->hooks))
			? collect($this->hooks[$routeName])
			: collect();

		// See if we have any global hooks
		$globalCallbacks = (array_key_exists('*', $this->hooks))
			? collect($this->hooks['*'])
			: collect();

		// Combine the two collections
		$callbacks = $globalCallbacks->concat($routeCallbacks);

		// Loop through the callbacks
		$callbacks->each(function ($callback) {
			if (is_callable($callback)) {
				// Grab the controller out of the container
				$controller = app('nova.controller');

				// Setup the parameters available to the callback
				$parameters = [
					$controller->data,
					$controller,
					request()->route(),
				];

				// Now execute the callback
				call_user_func_array($callback, $parameters);
			}
		});

		return $this;
	}
}
