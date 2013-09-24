<?php namespace Nova\Core\Repositories\Eloquent;

use SecurityTrait;
use AccessRoleModel;
use AccessTaskModel;
use AccessRoleRepositoryInterface;

class AccessRoleRepository implements AccessRoleRepositoryInterface {

	use SecurityTrait;
	
	/**
	 * Get everything out of the database.
	 *
	 * @return	Collection
	 */
	public function all()
	{
		return AccessRoleModel::all();
	}

	/**
	 * Get all the access tasks.
	 *
	 * @return	Collection
	 */
	public function allTasks()
	{
		return AccessTaskModel::all();
	}
	
	/**
	 * Create a new item.
	 *
	 * @param	array	$data	Data to use for creation
	 * @return	AccessRole
	 */
	public function create(array $data)
	{
		$item = AccessRoleModel::create($data);

		if ($item)
		{
			// Set the inherited tasks array
			$inheritedTasks = [];

			// Loop through the inherited tasks and get those
			foreach ($item->getInheritedTasks() as $tasks)
			{
				foreach ($tasks as $task)
				{
					$inheritedTasks[] = $task->id;
				}
			}

			if (array_key_exists('tasks', $data))
			{
				// Get the tasks from the POST
				$tasks = $data['tasks'];

				// Remove the inherited items from the list
				foreach ($tasks as $task)
				{
					if (in_array($task, $inheritedTasks))
					{
						unset($tasks[$task]);
					}
				}

				// Sync the roles_tasks table
				$item->tasks()->sync($tasks);
			}

			return $item;
		}

		return false;
	}

	/**
	 * Create a new role task.
	 *
	 * @param	array	$data	Data to use for creation
	 * @return	AccessTask
	 */
	public function createTask(array $data)
	{
		return AccessTaskModel::create($data);
	}

	/**
	 * Delete an access role.
	 *
	 * @param	int		$id		The ID to delete
	 * @param	int		$newId	The new ID to use
	 * @return	bool
	 */
	public function delete($id, $newId = false)
	{
		$id = $this->sanitizeInt($id);
		
		// Get the role
		$item = $this->find($id);

		if ($item)
		{
			// Sanitize the new ID
			$newId = $this->sanitizeInt($newId);

			if ( ! $newId)
				return false;

			// Update all users with this role
			foreach ($item->users as $user)
			{
				$user->update(['role_id' => $newId]);
			}

			// Delete the records from the pivot table
			$item->tasks()->detach();

			return $item->delete();
		}

		return false;
	}

	/**
	 * Delete a task.
	 *
	 * @param	int		$id		ID to delete
	 * @return	bool
	 */
	public function deleteTask($id)
	{
		$id = $this->sanitizeInt($id);

		// Get the task
		$item = $this->findTask($id);

		if ($item)
		{
			// Delete the records from the pivot table
			$item->roles()->detach();

			return $item->delete();
		}

		return false;
	}

	/**
	 * Duplicate an access role.
	 *
	 * @param	int		$id		Role ID to duplicate
	 * @param	array	$data	Additional data for the duplicated role
	 * @return	AccessRole
	 */
	public function duplicate($id, array $data)
	{
		$id = $this->sanitizeInt($id);

		// Get the role
		$item = $this->find($id);

		if ($item)
		{
			$insert = [
				'name'		=> (array_key_exists('name', $data)) ? $data['name'] : '',
				'desc'		=> $item->desc,
				'inherits'	=> $item->inherits,
			];

			// Create the new role
			$newItem = $this->create($insert);

			// Get the original tasks
			$originalTasks = $item->tasks->toSimpleArray();
			$originalTasks = array_keys($originalTasks);

			// Put the tasks into the new role
			$newItem->tasks()->sync($originalTasks);

			return $newItem;
		}

		return false;
	}

	/**
	 * Find an item by ID.
	 *
	 * @param	int		$id		ID to find
	 * @return	AccessRole
	 */
	public function find($id)
	{
		$id = $this->sanitizeInt($id);
		
		return AccessRoleModel::find($id);
	}

	/**
	 * Find a task by ID.
	 *
	 * @param	int		$id		ID to find
	 * @return	AccessTask
	 */
	public function findTask($id)
	{
		$id = $this->sanitizeInt($id);
		
		return AccessTaskModel::find($id);
	}

	/**
	 * Get all the task components.
	 *
	 * @return	Collection
	 */
	public function getTaskComponents()
	{
		return AccessTaskModel::group('component')->get();
	}

	/**
	 * Update an item.
	 *
	 * @param	int		$id		ID to update
	 * @param	array	$data	Data to use for update
	 * @return	AccessRole
	 */
	public function update($id, array $data)
	{
		$id = $this->sanitizeInt($id);

		// Get the role
		$item = $this->find($id);

		if ($item)
		{
			// Update the role information
			$item->update([
				'name' 		=> $data['name'],
				'desc' 		=> $data['desc'],
				'inherits'	=> (array_key_exists('inherits', $data)) ? implode(',', $data['inherits']) : '',
			]);

			// Set the inherited tasks array
			$inheritedTasks = [];

			// Loop through the inherited tasks and get those
			foreach ($item->getInheritedTasks() as $tasks)
			{
				foreach ($tasks as $task)
				{
					$inheritedTasks[] = $task->id;
				}
			}

			if (array_key_exists('tasks', $data))
			{
				// Remove the inherited items from the list
				foreach ($data['tasks'] as $task)
				{
					if (in_array($task, $inheritedTasks))
					{
						unset($tasks[$task]);
					}
				}

				// Sync the roles_tasks table
				$item->tasks()->sync($tasks);
			}

			return $item;
		}

		return false;
	}

	/**
	 * Update a role task.
	 *
	 * @param	int		$id		ID to update
	 * @param	array	$data	Data to use for update
	 * @return	AccessTask
	 */
	public function updateTask($id, array $data)
	{
		$id = $this->sanitizeInt($id);

		// Get the task
		$item = $this->findTask($id);

		if ($item)
			return $item->update($data);

		return false;
	}

}