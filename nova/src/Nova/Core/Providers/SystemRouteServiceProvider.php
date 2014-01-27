<?php namespace Nova\Core\Providers;

use App,
	Str,
	File,
	Cache,
	Route;
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
		$routes = Cache::get('nova.routes');

		// Get the install status
		$installed = $this->app['nova.setup']->installed(false);

		// We don't have any routes, but the system is installed
		if ($routes === null and (is_bool($installed) and $installed))
		{
			// Cache the system routes
			\SystemRouteModel::cache();

			// Retrieve the routes again
			$routes = Cache::get('nova.routes');
		}

		if ($routes === null)
		{
			Route::get('/', 'Nova\Core\Controllers\Main@getIndex');

			Route::get('ajax/get/rank/image/{id}/{return}', 'Nova\Core\Controllers\Ajax\Get@getRank');
			Route::get('ajax/get/position/{id}/{return}', 'Nova\Core\Controllers\Ajax\Get@getPosition');

			Route::get('login', 'Nova\Core\Controllers\Login@getIndex');
			Route::post('login', 'Nova\Core\Controllers\Login@postIndex');

			Route::get('admin', 'Nova\Core\Controllers\Admin\Admin@getIndex');
			Route::get('admin/routes', 'Nova\Core\Controllers\Admin\Admin@getRoutes');
			Route::post('admin/routes', 'Nova\Core\Controllers\Admin\Admin@postRoutes');
		}
		else
		{
			// GET routes
			if (array_key_exists('get', $routes) and count($routes['get']) > 0)
			{
				foreach ($routes['get'] as $route)
				{
					$options = [
						'as'	=> $route['name'],
						'uses'	=> $route['resource'],
					];

					if ($route['conditions'] !== null)
					{
						Route::get($route['uri'], $options)
							->where($this->parseRouteConditions($route['conditions']));
					}
					else
					{
						Route::get($route['uri'], $options);
					}
				}
			}
			
			// POST routes
			if (array_key_exists('post', $routes) and count($routes['post']) > 0)
			{
				foreach ($routes['post'] as $route)
				{
					$options = [
						'as'	=> $route['name'],
						'uses'	=> $route['resource'],
					];

					if ( ! empty($route['conditions']))
					{
						Route::post($route['uri'], $options)
							->where($this->parseRouteConditions($route['conditions']));
					}
					else
					{
						Route::post($route['uri'], $options);
					}
				}
			}

			// PUT routes
			if (array_key_exists('put', $routes) and count($routes['put']) > 0)
			{
				foreach ($routes['put'] as $route)
				{
					$options = [
						'as'	=> $route['name'],
						'uses'	=> $route['resource'],
					];

					if ( ! empty($route['conditions']))
					{
						Route::put($route['uri'], $options)
							->where($this->parseRouteConditions($route['conditions']));
					}
					else
					{
						Route::put($route['uri'], $options);
					}
				}
			}

			// DELETE routes
			if (array_key_exists('delete', $routes) and count($routes['delete']) > 0)
			{
				foreach ($routes['delete'] as $route)
				{
					$options = [
						'as'	=> $route['name'],
						'uses'	=> $route['resource'],
					];

					if ( ! empty($route['conditions']))
					{
						Route::delete($route['uri'], $options)
							->where($this->parseRouteConditions($route['conditions']));
					}
					else
					{
						Route::delete($route['uri'], $options);
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
		require SRCPATH.'Forum/routes.php';
		require SRCPATH.'Wiki/routes.php';
	}

	/**
	 * Pull in the route files for all installed modules.
	 */
	protected function bootModuleRoutes()
	{
		// Get the module list
		$modules = Cache::get('nova.modules', []);

		// Loop through the modules and include their route files
		foreach ($modules as $m)
		{
			if (File::exists(APPPATH."src/Modules/{$m}/routes.php"))
			{
				include APPPATH."src/Modules/{$m}/routes.php";
			}
		}
	}

	/**
	 * If we're in development, pull in the test routes.
	 */
	protected function bootDevRoutes()
	{
		// Pull in the dev routes if we're local
		if (App::environment() == 'local')
		{
			require SRCPATH.'Core/routes_dev.php';
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