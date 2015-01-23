<?php namespace Nova\Foundation\Providers;

use Str;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider {

	/**
	 * This namespace is applied to the controller routes in your routes file.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = false;

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function boot(Router $router)
	{
		parent::boot($router);

		//$this->setSystemRoutes();
	}

	/**
	 * Define the routes for the application.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function map(Router $router)
	{
		$router->group(['namespace' => $this->namespace], function($router)
		{
			require app_path('Foundation/Http/routes.php');
			require base_path('routes.php');
		});
	}

	/**
	 * Grab the routes from the cache and create the route entries from that
	 * information. If the routes aren't cached, create some basic routes so
	 * that the user can get to some place where Nova can create the cache file.
	 *
	 * @return	void
	 */
	protected function setSystemRoutes()
	{
		// Grab all the routes from the cache
		$routes = $this->app['cache']->get('nova.routes');

		if (count($routes) > 0)
		{
			foreach ($routes as $route)
			{
				$options = [
					'as'		=> $route['name'],
					'resource'	=> $route['resource'],
				];

				if ( ! empty($route['conditions']))
				{
					$this->app['router']->addRoute($route['verb'], $route['uri'], $options)
						->where($this->parseRouteConditions($route['conditions']));
				}
				else
				{
					$this->app['router']->addRoute($route['verb'], $route['uri'], $options);
				}
			}
		}
	}

	/**
	 * Parse the route conditions into the proper format for use on the router.
	 *
	 * @internal
	 * @param	string	$conditions	The route conditions as a string
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