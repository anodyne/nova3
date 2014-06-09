<?php namespace Nova\Core\System\Repositories\Eloquent;

use UtilityTrait,
	SecurityTrait,
	SystemRouteModel,
	RouteProtectedException,
	SystemRouteRepositoryInterface;

class SystemRouteRepository implements SystemRouteRepositoryInterface {

	use UtilityTrait,
		SecurityTrait;

	public function all()
	{
		return SystemRouteModel::all();
	}
	
	/**
	 * Get everything out of the database and sort into an array of core and
	 * user routes.
	 *
	 * @return	array
	 */
	public function allAsArray()
	{
		// Get all the routes
		$items = $this->all();

		// Start a holding array
		$routes = [];

		// Make sure we have routes
		if ($items->count() > 0)
		{
			foreach ($items as $item)
			{
				// Separate the routes into CORE and USER routes
				if ((bool) $item->protected === true)
				{
					$routes['core'][] = $item;
				}
				else
				{
					$routes['user'][] = $item;
				}
			}
		}

		return $routes;
	}

	/**
	 * Get the routes as JSON for use in autocomplete.
	 *
	 * @return	string
	 */
	public function allAsJson()
	{
		// Get all the routes
		$routes = $this->all();

		// Start the route source list
		$routeList = [];

		foreach ($routes as $route)
		{
			if ((array_key_exists($route->name, $routeList) and ! (bool) $route->protected)
					or ! array_key_exists($route->name, $routeList))
			{
				$routeList[$route->name] = $route->name;
			}
		}

		return json_encode($routeList);
	}

	/**
	 * Cache the routes.
	 *
	 * @return	void
	 */
	public function cache()
	{
		SystemRouteModel::cache();
	}
	
	/**
	 * Create a new route.
	 *
	 * @param	array	$data		Data to use for creation
	 * @param	bool	$setFlash	Set the flash message?
	 * @return	SystemRoute
	 */
	public function create(array $data, $setFlash = true)
	{
		// Create the route
		$item = SystemRouteModel::create($data);

		if ($setFlash)
		{
			// Set the flash info
			$status = ($item) ? 'success' : 'danger';
			$message = ($item) 
				? lang('Short.alert.success.create', langConcat('route'))
				: lang('Short.alert.failure.create', langConcat('route'));

			// Flash the session
			$this->setFlashMessage($status, $message);
		}

		return $item;
	}

	/**
	 * Delete a route.
	 *
	 * @param	int		$id			ID to delete
	 * @param	bool	$setFlash	Set the flash message?
	 * @return	SystemRoute
	 */
	public function delete($id, $setFlash = true)
	{
		// Get the route
		$item = $this->find($id);

		if ($item)
		{
			// If this is a protected route, throw an exception because it can't
			// be deleted
			if ((bool) $item->protected)
			{
				throw new RouteProtectedException;
			}

			// Delete the route
			$delete = $item->delete();

			if ($setFlash)
			{
				// Set the flash info
				$status = ($delete) ? 'success' : 'danger';
				$message = ($delete) 
					? lang('Short.alert.success.delete', langConcat('route'))
					: lang('Short.alert.failure.delete', langConcat('route'));

				// Flash the session
				$this->setFlashMessage($status, $message);
			}

			if ($delete)
			{
				return $item;
			}
		}

		return false;
	}

	/**
	 * Duplicate a route.
	 *
	 * @param	int		$id			Route ID to duplicate
	 * @param	bool	$setFlash	Set the flash message?
	 * @return	SystemRoute
	 */
	public function duplicate($id, $setFlash = true)
	{
		// Get the original route
		$item = $this->find($id);

		if ($item)
		{
			// Create the new route
			$route = $this->create([
				'name'		=> $item->name,
				'verb'		=> $item->verb,
				'uri'		=> $item->uri,
				'resource'	=> $item->resource,
			]);

			if ($setFlash)
			{
				// Set the flash info
				$status = ($route) ? 'success' : 'danger';
				$message = ($route) 
					? lang('Short.alert.success.duplicate', langConcat('core route'))
					: lang('Short.alert.failure.duplicate', langConcat('core route'));

				// Flash the session
				$this->setFlashMessage($status, $message);
			}

			return $route;
		}

		return false;
	}

	/**
	 * Find an item by its ID.
	 *
	 * @param	int		$id		ID to find
	 * @return	SystemRoute
	 */
	public function find($id)
	{
		return SystemRouteModel::find($this->sanitizeInt($id));
	}

	/**
	 * Find a route based on its name.
	 *
	 * @param	string	$name	Route Name
	 * @param	string	$verb	HTTP verb to look for
	 * @param	bool	$count	Return only the count of items
	 * @return	Collection
	 */
	public function findByName($name, $verb = 'get', $count = false)
	{
		$routes = SystemRouteModel::name($name, $verb)->get();

		if ($count)
		{
			return $routes->count();
		}

		return $routes;
	}

	/**
	 * Find a route based on its URI.
	 *
	 * @param	string	$uri	Route URI
	 * @param	string	$verb	HTTP verb to look for
	 * @param	bool	$count	Return only the count of items
	 * @return	Collection
	 */
	public function findByUri($uri, $verb = 'get', $count = false)
	{
		$routes = SystemRouteModel::uri($uri, $verb)->get();

		if ($count)
		{
			return $routes->count();
		}

		return $routes;
	}

	/**
	 * Update a route.
	 *
	 * @param	int		$id			ID to update
	 * @param	array	$data		Data to use for update
	 * @param	bool	$setFlash	Set the flash message?
	 * @return	SystemRoute
	 */
	public function update($id, array $data, $setFlash = true)
	{
		// Get the route
		$item = $this->find($id);

		if ($item)
		{
			// Update the route
			$update = $item->fill($data)->save();

			if ($setFlash)
			{
				// Set the flash info
				$status = ($update) ? 'success' : 'danger';
				$message = ($update) 
					? lang('Short.alert.success.update', langConcat('route'))
					: lang('Short.alert.failure.update', langConcat('route'));

				// Flash the session
				$this->setFlashMessage($status, $message);
			}

			if ($update)
			{
				return $item;
			}
		}

		return false;
	}

}