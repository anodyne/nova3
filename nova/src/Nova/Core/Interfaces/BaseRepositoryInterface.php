<?php namespace Nova\Core\Interfaces;

interface BaseRepositoryInterface {

	/**
	 * Get everything out of the database.
	 *
	 * @return	Collection
	 */
	public function all();
	
	/**
	 * Create a new item.
	 *
	 * @param	array	$data		Data to use for creation
	 * @param	bool	$setFlash	Set a flash message?
	 * @return	object
	 */
	public function create(array $data, $setFlash = true);

	/**
	 * Delete an item.
	 *
	 * @param	int		$id			ID to delete
	 * @param	bool	$setFlash	Set a flash message?
	 * @return	bool
	 */
	public function delete($id, $setFlash = true);

	/**
	 * Find an item by ID.
	 *
	 * @param	int		$id		ID to find
	 * @return	object
	 */
	public function find($id);

	/**
	 * Update an item.
	 *
	 * @param	int		$id			ID to update
	 * @param	array	$data		Data to use for update
	 * @param	bool	$setFlash	Set flash message?
	 * @return	object
	 */
	public function update($id, array $data, $setFlash = true);

}