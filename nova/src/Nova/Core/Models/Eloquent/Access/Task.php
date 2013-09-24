<?php namespace Nova\Core\Models\Eloquent\Access;

use Event;
use Model;
use Config;

class Task extends Model {

	public $timestamps = false;
	
	protected $table = 'tasks';

	protected $fillable = [
		'name', 'desc', 'component', 'action', 'level',
	];
	
	protected static $properties = [
		'id', 'name', 'desc', 'component', 'action', 'level',
	];

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
		return $this->belongsToMany('AccessRoleModel', 'roles_tasks');
	}

	/*
	|--------------------------------------------------------------------------
	| Model Scopes
	|--------------------------------------------------------------------------
	*/

	/**
	 * Scope the query to a specific task.
	 *
	 * @param	Builder		The query builder
	 * @param	string		Dot-delimited string (component.action.level)
	 * @return	void
	 */
	public function scopeTask($query, $task)
	{
		// Break the task up into an array
		$taskArray = explode('.', $task);

		// Break the task up into its components
		list($component, $action, $level) = $taskArray;

		$query->where('component', $component)
			->where('action', $action)
			->where('level', $level);
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
		$a = Config::get('app.aliases');

		// Setup the listeners
		static::setupEventListeners($a['AccessTaskModel'], $a['AccessTaskModelEventHandler']);
	}

}