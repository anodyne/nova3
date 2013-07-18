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
		/*// Get all routes
		$routes = $this->app['cache']->get('nova.routes');

		//sd($routes);

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

			// The other option is to run a custom Artisan task that will generate the routes for the user
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
			/*if (array_key_exists('post', $routes) and count($routes['post']) > 0)
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


		}*/

		$this->app['router']->get('foo', 'App\Controllers\Foo@getIndex');
	}

	/*private function parseRouteConditions($conditions)
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
	}*/

}