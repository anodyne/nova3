<?php namespace nova\core\providers;

use Str;
use Route;
use Illuminate\Support\ServiceProvider;

class SystemRouteServiceProvider extends ServiceProvider {

	protected $defer = false;

	public function register()
	{
		//
	}

	public function boot()
	{
		$this->bootSystemRoutes();
		$this->bootAdditionalRoutes();
		$this->bootModuleRoutes();
		$this->bootDevRoutes();
	}

	/**
	 * Grab the routes from the cache and create the route entries from that
	 * information. If the routes aren't cached, create some basic routes so
	 * that the user can get to some place where they can create the cache file.
	 */
	protected function bootSystemRoutes()
	{
		// Get all routes
		$routes = $this->app['cache']->get('nova.routes');

		if ($routes === null)
		{
			Route::get('/', 'nova\core\controllers\Main@getIndex');

			Route::get('ajax/get/rank/image/{id}/{return}', 'nova\core\controllers\ajax\Get@getRank');
			Route::get('ajax/get/position/{id}/{return}', 'nova\core\controllers\ajax\Get@getPosition');

			Route::get('login', 'nova\core\controllers\Login@getIndex');
			Route::post('login', 'nova\core\controllers\Login@postIndex');

			Route::get('admin', 'nova\core\controllers\admin\Admin@getIndex');
			Route::get('admin/routes', 'nova\core\controllers\admin\Main@getRoutes');
			Route::post('admin/routes', 'nova\core\controllers\admin\Main@postRoutes');
		}
		else
		{
			// GET routes
			if (array_key_exists('get', $routes) and count($routes['get']) > 0)
			{
				foreach ($routes['get'] as $route)
				{
					if ($route['conditions'] !== null)
					{
						Route::get($route['uri'], $route['resource'])
							->where($this->parseRouteConditions($route['conditions']));
					}
					else
					{
						Route::get($route['uri'], $route['resource']);
					}
				}
			}

			// POST routes
			if (array_key_exists('post', $routes) and count($routes['post']) > 0)
			{
				foreach ($routes['post'] as $route)
				{
					if ( ! empty($route['conditions']))
					{
						Route::post($route['uri'], $route['resource'])
							->where($this->parseRouteConditions($route['conditions']));
					}
					else
					{
						Route::post($route['uri'], $route['resource']);
					}
				}
			}

			// PUT routes
			if (array_key_exists('put', $routes) and count($routes['put']) > 0)
			{
				foreach ($routes['put'] as $route)
				{
					if ( ! empty($route['conditions']))
					{
						Route::put($route['uri'], $route['resource'])
							->where($this->parseRouteConditions($route['conditions']));
					}
					else
					{
						Route::put($route['uri'], $route['resource']);
					}
				}
			}

			// DELETE routes
			if (array_key_exists('delete', $routes) and count($routes['delete']) > 0)
			{
				foreach ($routes['delete'] as $route)
				{
					if ( ! empty($route['conditions']))
					{
						Route::delete($route['uri'], $route['resource'])
							->where($this->parseRouteConditions($route['conditions']));
					}
					else
					{
						Route::delete($route['uri'], $route['resource']);
					}
				}
			}
		}
	}

	/**
	 * Pull in any additional routes files we need.
	 */
	protected function bootAdditionalRoutes()
	{
		// Pull in the core routes
		require SRCPATH.'forum/routes.php';
		require SRCPATH.'wiki/routes.php';
	}

	/**
	 * Pull in the route files for all installed modules.
	 */
	protected function bootModuleRoutes()
	{
		// Get the module list
		$modules = $this->app['cache']->get('nova.modules', []);

		// Loop through the modules and include their route files
		foreach ($modules as $m)
		{
			if ($this->app['file']->exists(APPPATH."modules/{$m}/routes.php"))
			{
				include APPPATH."modules/{$m}/routes.php";
			}
		}
	}

	/**
	 * If we're in development, pull in the test routes.
	 */
	protected function bootDevRoutes()
	{
		// Pull in the dev routes if we're local
		if ($this->app->environment() == 'local')
		{
			require SRCPATH.'core/routes/dev.php';
		}
	}

	/**
	 * Parse the route conditions into the proper format for use on the router.
	 *
	 * @internal
	 * @param	string	The route conditions as a string
	 * @return	array
	 */
	private function parseRouteConditions($conditions)
	{
		// Create an empty array for storing conditions
		$finalConditions = [];
		
		// We have a pipe, so we need to break things apart twice
		if (Str::contains($conditions, '|'))
		{
			// Create an array of conditions
			$conditionsArr = explode('|', $conditions);

			// Loop through the conditions array
			foreach ($conditionsArr as $c)
			{
				// Break the conditions up
				list($name, $pattern) = explode('.', $c);

				// Add the conditions to the final array
				$finalConditions[] = [$name => $condition];
			}
		}
		else
		{
			// Break the conditions up
			list($name, $pattern) = explode('.', $conditions);

			// Set the final conditions
			$finalConditions[$name] = $pattern;
		}

		return $finalConditions;
	}

}