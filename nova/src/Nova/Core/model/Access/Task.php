<?php namespace Nova\Core\Model\Access;

use Model;

class Task extends Model {

	public $timestamps = false;
	
	protected $table = 'tasks';

	protected $fillable = array(
		'name', 'desc', 'component', 'action', 'level', 'dependencies',
	);
	
	protected static $properties = array(
		'id', 'name', 'desc', 'component', 'action', 'level', 'dependencies',
	);

	/**
	 * Belongs To Many: Roles (through Roles Tasks)
	 */
	public function roles()
	{
		return $this->belongsToMany('AccessRole', 'roles_tasks');
	}

	/**
	 * Get all the components.
	 *
	 * @return	Collection
	 */
	public static function getComponents()
	{
		// Start a new Query Builder
		$query = static::startQuery();

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

		// Start a new Query Builder
		$query = static::startQuery();

		return $query->where('component', $component)
			->where('action', $action)
			->where('level', $level)
			->first();
	}

}