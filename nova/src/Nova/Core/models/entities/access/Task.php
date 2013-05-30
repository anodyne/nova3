<?php namespace Nova\Core\Models\Entities\Access;

use Event;
use Model;
use Config;

class Task extends Model {

	public $timestamps = false;
	
	protected $table = 'tasks';

	protected $fillable = array(
		'name', 'desc', 'component', 'action', 'level',
	);
	
	protected static $properties = array(
		'id', 'name', 'desc', 'component', 'action', 'level',
	);

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/

	/**
	 * Belongs To Many: Roles (through Roles Tasks)
	 */
	public function roles()
	{
		return $this->belongsToMany('AccessRole', 'roles_tasks');
	}

	/*
	|--------------------------------------------------------------------------
	| Model Methods
	|--------------------------------------------------------------------------
	*/

	/**
	 * Boot the model and define the event listeners.
	 *
	 * @return	void
	 */
	public static function boot()
	{
		parent::boot();

		// Get all the aliases
		$classes = Config::get('app.aliases');

		Event::listen("eloquent.created: {$classes['AccessTask']}", "{$classes['AccessTaskHandler']}@afterCreate");
		Event::listen("eloquent.updated: {$classes['AccessTask']}", "{$classes['AccessTaskHandler']}@afterUpdate");
		Event::listen("eloquent.deleting: {$classes['AccessTask']}", "{$classes['AccessTaskHandler']}@beforeDelete");
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