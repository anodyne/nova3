<?php namespace Nova\Core\Repositories\Eloquent;

use SystemRoute;
use SecurityTrait;
use SystemRouteRepositoryInterface;

class SystemRouteRepository implements SystemRouteRepositoryInterface {

	use SecurityTrait;

	/*
	|--------------------------------------------------------------------------
	| BaseRepositoryInterface Implementation
	|--------------------------------------------------------------------------
	*/
	
	/**
	 * Get everything out of the database.
	 *
	 * @return	Collection
	 */
	public function all()
	{
		return SystemRoute::all();
	}
	
	/**
	 * Create a new item.
	 *
	 * @param	array	$data	Data to use for creation
	 * @return	SystemRoute
	 */
	public function create(array $data)
	{
		return SystemRoute::create($data);
	}

	/**
	 * Delete an item.
	 *
	 * @param	int		$id		ID to delete
	 * @return	bool
	 */
	public function delete($id)
	{
		$id = $this->sanitizeInt($id);

		$item = $this->find($id);

		if ($item)
			return $item->delete();

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
		$id = $this->sanitizeInt($id);

		return SystemRoute::find($id);
	}

	/**
	 * Update an item.
	 *
	 * @param	int		$id		ID to update
	 * @param	array	$data	Data to use for update
	 * @return	SystemRoute
	 */
	public function update($id, array $data)
	{
		$id = $this->sanitizeInt($id);
		
		$item = $this->find($id);

		if ($item)
			return $item->update($data);

		return false;
	}

	/*
	|--------------------------------------------------------------------------
	| SystemRouteRepositoryInterface Implementation
	|--------------------------------------------------------------------------
	*/

	/**
	 * Duplicate a system route.
	 *
	 * @param	int		$id		Route ID to duplicate
	 * @return	SystemRoute
	 */
	public function duplicate($id)
	{
		$id = $this->sanitizeInt($id);

		$item = $this->find($id);

		if ($item)
		{
			return $this->create([
				'name'		=> $item->name,
				'verb'		=> $item->verb,
				'uri'		=> $item->uri,
				'resource'	=> $item->resource,
			]);
		}

		return false;
	}

}