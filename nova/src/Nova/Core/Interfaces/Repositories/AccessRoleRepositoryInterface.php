<?php namespace Nova\Core\Interfaces\Repositories;

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
	 * @param	array	$data	Data to use for deletion
	 * @return	bool
	 */
	public function delete(array $data);

	/**
	 * Delete a role task.
	 *
	 * @param	array	$data	Data to use for deletion
	 * @return	bool
	 */
	public function deleteTask(array $data);

	/**
	 * Duplicate an access role.
	 *
	 * @param	array	$data	Data for the duplicated role
	 * @return	AccessRole
	 */
	public function duplicate(array $data);

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
	 * @param	array	$data	Data to use for update
	 * @return	AccessTask
	 */
	public function updateTask(array $data);

}