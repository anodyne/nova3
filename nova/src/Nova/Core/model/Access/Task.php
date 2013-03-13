<?php namespace Nova\Core\Model\Access;

use Model;
use AccessRoleModel;

class Task extends Model {

	protected $table = 'tasks';
	
	protected static $properties = array(
		'id', 'name', 'desc', 'component', 'action', 'level', 'dependencies',
	);

	/**
	 * Belongs To Many: Roles (through Roles Tasks)
	 */
	public function roles()
	{
		return $this->belongsToMany('AccessRoleModel', 'roles_tasks');
	}

	/**
	 * Get all the components.
	 *
	 * @return	Collection
	 */
	public static function getComponents()
	{
		// Get a new instance of the model
		$instance = new static;

		// Start a new Query Builder
		$query = $instance->newQuery();

		return $query->groupBy('component')->get();
	}

	/**
	 * Get a task based on a series of conditions.
	 *
	 * @param	string	Dot-delimited tasks (component.action.level)
	 * @return	Task
	 */
	public static function getTask($task)
	{
		// Break the task up into an array
		$taskArray = explode('.', $task);

		// Break the task up into its components
		list($component, $action, $level) = $taskArray;

		// Get a new instance of the model
		$instance = new static;

		// Start a new Query Builder
		$query = $instance->newQuery();

		return $query->where('component', $component)
			->where('action', $action)
			->where('level', $level)
			->first();
	}

}