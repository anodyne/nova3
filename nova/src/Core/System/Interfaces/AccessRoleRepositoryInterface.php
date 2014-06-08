<?php namespace Nova\Core\System\Interfaces;

use BaseRepositoryInterface;

interface AccessRoleRepositoryInterface extends BaseRepositoryInterface {

	/**
	 * Get all the access tasks.
	 *
	 * @return	Collection
	 */
	public function allTasks();

	/**
	 * Create a new role task.
	 *
	 * @param	array	$data	Data to use for creation
	 * @return	AccessTask
	 */
	public function createTask(array $data);

	/**
	 * Delete an access role.
	 *
	 * @param	int		$id		The ID to delete
	 * @param	int		$newId	The new ID to use
	 * @return	bool
	 */
	public function delete($id, $newId = false);

	/**
	 * Delete a role task.
	 *
	 * @param	int		$id		ID to delete
	 * @return	bool
	 */
	public function deleteTask($id);

	/**
	 * Duplicate an access role.
	 *
	 * @param	int		$id		Role ID to duplicate
	 * @param	array	$data	Additional data for the duplicated role
	 * @return	AccessRole
	 */
	public function duplicate($id, array $data);

	/**
	 * Find a task by ID.
	 *
	 * @param	int		$id		ID to find
	 * @return	AccessTask
	 */
	public function findTask($id);

	/**
	 * Get all the task components.
	 *
	 * @return	Collection
	 */
	public function getTaskComponents();

	/**
	 * Update a role task.
	 *
	 * @param	int		$id		ID to update
	 * @param	array	$data	Data to use for update
	 * @return	AccessTask
	 */
	public function updateTask($id, array $data);

}