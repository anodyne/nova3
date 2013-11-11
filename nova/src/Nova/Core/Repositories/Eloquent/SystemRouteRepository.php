<?php namespace Nova\Core\Repositories\Eloquent;

use UtilityTrait;
use SecurityTrait;
use SystemRouteModel;
use SystemRouteRepositoryInterface;

class SystemRouteRepository implements SystemRouteRepositoryInterface {

	use UtilityTrait;
	use SecurityTrait;
	
	/**
	 * Get everything out of the database.
	 *
	 * @return	array
	 */
	public function all()
	{
		// Get all the items
		$items = SystemRouteModel::all();

		// Start a holding array
		$routes = [];

		// Make sure we have routes
		if ($items->count() > 0)
		{
			// Loop through the routes
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
	 * Cache the system routes.
	 *
	 * @return	void
	 */
	public function cache()
	{
		SystemRouteModel::cache();
	}
	
	/**
	 * Create a new item.
	 *
	 * @param	array	$data		Data to use for creation
	 * @param	bool	$setFlash	Set the flash message?
	 * @return	SystemRoute
	 */
	public function create(array $data, $setFlash = true)
	{
		// Create the route
		$route = SystemRouteModel::create($data);

		if ($setFlash)
		{
			// Set the flash info
			$status = ($route) ? 'success' : 'danger';
			$message = ($route) 
				? lang('Short.alert.success.create', langConcat('route'))
				: lang('Short.alert.failure.create', langConcat('route'));

			// Flash the session
			$this->setFlashMessage($status, $message);
		}

		return $route;
	}

	/**
	 * Delete an item.
	 *
	 * @param	int		$id		ID to delete
	 * @return	bool
	 */
	public function delete($id, $setFlash = true)
	{
		// Get the route
		$item = $this->find($id);

		if ($item)
		{
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
	 * Duplicate a system route.
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
	 * Find an item by ID.
	 *
	 * @param	int		$id		ID to find
	 * @return	SystemRoute
	 */
	public function find($id)
	{
		return SystemRouteModel::find($this->sanitizeInt($id));
	}

	/**
	 * Update an item.
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
			$update = $item->update($data);

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

			return $update;
		}

		return false;
	}

}