<?php namespace Nova\Core\Providers;

use Str;
use Illuminate\Support\ServiceProvider;

class SystemRouteProvider extends ServiceProvider {

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

	protected function bootSystemRoutes()
	{
		// Get all routes
		$routes = $this->app['cache']->get('nova.routes');

		if ($routes === null)
		{
			$this->app['router']->get('/', 'Nova\Core\Controllers\Main@getIndex');
			$this->app['router']->get('main/index', 'Nova\Core\Controllers\Main@getIndex');

			$this->app['router']->get('ajax/get/rank/image/{id}/{return}', 'Nova\Core\Controllers\Ajax\Get@getRank');
			$this->app['router']->get('ajax/get/position/{id}/{return}', 'Nova\Core\Controllers\Ajax\Get@getPosition');

			$this->app['router']->get('login', 'Nova\Core\Controllers\Login@getIndex');
			$this->app['router']->get('login/index', 'Nova\Core\Controllers\Login@getIndex');
			$this->app['router']->post('login/index', 'Nova\Core\Controllers\Login@postIndex');

			$this->app['router']->get('admin/main/index', 'Nova\Core\Controllers\Admin\Main@getIndex');
			$this->app['router']->get('admin/main/pages', 'Nova\Core\Controllers\Admin\Main@getPages');
			$this->app['router']->post('admin/main/pages', 'Nova\Core\Controllers\Admin\Main@postPages');
		}
		else
		{
			// GET routes
			if (array_key_exists('get', $routes) and count($routes['get']) > 0)
			{
				foreach ($routes['get'] as $route)
				{
					//sd($route);
					if ($route['conditions'] !== null)
					{
						$this->app['router']->get($route['uri'], $route['resource'])
							->where($this->parseRouteConditions($route['conditions']));
					}
					else
					{
						$this->app['router']->get($route['uri'], $route['resource']);
					}

					\Log::info($route['uri']);
				}
			}

			// POST routes
			if (array_key_exists('post', $routes) and count($routes['post']) > 0)
			{
				foreach ($routes['post'] as $route)
				{
					if ( ! empty($route['conditions']))
					{
						$this->app['router']->post($route['uri'], $route['resource'])
							->where($this->parseRouteConditions($route['conditions']));
					}
					else
					{
						$this->app['router']->post($route['uri'], $route['resource']);
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
						$this->app['router']->put($route['uri'], $route['resource'])
							->where($this->parseRouteConditions($route['conditions']));
					}
					else
					{
						$this->app['router']->put($route['uri'], $route['resource']);
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
						$this->app['router']->delete($route['uri'], $route['resource'])
							->where($this->parseRouteConditions($route['conditions']));
					}
					else
					{
						$this->app['router']->delete($route['uri'], $route['resource']);
					}
				}
			}
		}
	}

	protected function bootAdditionalRoutes()
	{
		// Pull in the core routes
		require SRCPATH.'api/routes.php';
		require SRCPATH.'forum/routes.php';
		require SRCPATH.'wiki/routes.php';
	}

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

	protected function bootDevRoutes()
	{
		// Pull in the test routes if we're local
		if ($this->app->environment() == 'local')
		{
			require SRCPATH.'core/routes/test.php';
		}
	}

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