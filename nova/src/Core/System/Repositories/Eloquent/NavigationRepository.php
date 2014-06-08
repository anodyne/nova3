<?php namespace Nova\Core\System\Repositories\Eloquent;

use NavModel,
	UtilityTrait,
	SecurityTrait,
	NavigationRepositoryInterface;

class NavigationRepository implements NavigationRepositoryInterface {

	use UtilityTrait,
		SecurityTrait;
	
	/**
	 * Get everything out of the database.
	 *
	 * @return	Collection
	 */
	public function all()
	{
		return NavModel::all();
	}

	/**
	 * Get all site navigation items by their category.
	 *
	 * @return	array
	 */
	public function allByCategory()
	{
		// Get all the items
		$all = $this->all();

		if ($all)
		{
			foreach ($all as $a)
			{
				$items[$a->group][] = $a;
			}

			return $items;
		}

		return [];
	}

	/**
	 * Get all site navigation items by their type.
	 *
	 * @return	array
	 */
	public function allByType($type = false)
	{
		// Get all the items
		$all = $this->all();

		if ($all)
		{

			if ($type)
			{
				return $all->filter(function($a) use ($type)
				{
					return $a->type == $type;
				});
			}

			foreach ($all as $a)
			{
				$items[$a->type][] = $a;
			}

			return $items;
		}

		return [];
	}

	/**
	 * Get all site navigation items by their type and category.
	 *
	 * @return	array
	 */
	public function allByTypeAndCategory()
	{
		// Get all the items
		$all = $this->all();

		if ($all)
		{
			foreach ($all as $a)
			{
				$items[$a->type][$a->group][] = $a;
			}

			return $items;
		}

		return [];
	}
	
	/**
	 * Create a new navigation item.
	 *
	 * @param	array	$data		Data to use for creation
	 * @param	bool	$setFlash	Set a flash message?
	 * @return	Nav
	 */
	public function create(array $data, $setFlash = true)
	{
		// Create the form
		$nav = Nav::create($data);

		if ($setFlash)
		{
			// Set the flash info
			$status = ($nav) ? 'success' : 'danger';
			$message = ($nav) 
				? lang('Short.alert.success.create', langConcat('navigation item'))
				: lang('Short.alert.failure.create', langConcat('navigation item'));

			// Flash the session
			$this->setFlashMessage($status, $message);
		}

		return $nav;

	}

	/**
	 * Delete a navigation item.
	 *
	 * @param	int		$id			ID to delete
	 * @param	bool	$setFlash	Set a flash message?
	 * @return	Nav
	 */
	public function delete($id, $setFlash = true)
	{
		// Get the item
		$nav = $this->find($id);

		if ($nav)
		{
			// Delete the item
			$delete = $nav->delete();

			if ($setFlash)
			{
				// Set the flash info
				$status = ($delete) ? 'success' : 'danger';
				$message = ($delete)
					? lang('Short.alert.success.delete', langConcat('navigation item'))
					: lang('Short.alert.failure.delete', langConcat('navigation item'));

				// Flash the session
				$this->setFlashMessage($status, $message);
			}

			return $nav;
		}

		return false;
	}

	/**
	 * Duplicate a navigation item.
	 *
	 * @param	int		$id			Navigation ID to duplicate
	 * @param	string	$newName	New name of the duplicated item
	 * @param	bool	$setFlash	Set a flash message?
	 * @return	Nav
	 */
	public function duplicate($id, $newName, $setFlash = true)
	{
		// Get the item
		$nav = $this->find($id);

		if ($nav)
		{
			// Grab the item and turn it into an array
			$duplicateArr = $nav->toArray();

			// Change the name
			$duplicateArr['name'] = $newName;

			$duplicate = $this->create($duplicateArr, false);

			if ($setFlash)
			{
				// Set the flash info
				$status = ($duplicate) ? 'success' : 'danger';
				$message = ($duplicate)
					? lang('Short.alert.success.duplicate', langConcat('navigation item'))
					: lang('Short.alert.failure.duplicate', langConcat('navigation item'));

				// Flash the session
				$this->setFlashMessage($status, $message);
			}

			return $duplicate;
		}

		return false;
	}

	/**
	 * Find an item by ID.
	 *
	 * @param	int		$id		ID to find
	 * @return	Nav
	 */
	public function find($id)
	{
		return NavModel::find($this->sanitizeInt($id));
	}

	public function getNavTypes()
	{
		// Get all the items
		$items = NavModel::groupBy('type')->get();

		if ($items)
		{
			foreach ($items as $item)
			{
				$values[] = $item->type;
			}

			return $values;
		}

		return [];
	}

	/**
	 * Update a navigation item.
	 *
	 * @param	int		$id			Navigation ID to update
	 * @param	array	$data		Data to use for the update
	 * @param	bool	$setFlash	Set a flash message?
	 * @return	Nav
	 */
	public function update($id, array $data, $setFlash = true)
	{
		// Get the item
		$nav = $this->find($id);

		// Update the item
		$update = $nav->update($data);

		if ($setFlash)
		{
			// Set the flash info
			$status = ($update) ? 'success' : 'danger';
			$message = ($update) 
				? lang('Short.alert.success.update', langConcat('navigation item'))
				: lang('Short.alert.failure.update', langConcat('navigation item'));

			// Flash the session
			$this->setFlashMessage($status, $message);
		}

		return $update;
	}

}