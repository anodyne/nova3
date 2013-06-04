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

		Event::listen("eloquent.creating: {$a['AccessTask']}", "{$a['AccessTaskEventHandler']}@beforeCreate");
		Event::listen("eloquent.created: {$a['AccessTask']}", "{$a['AccessTaskEventHandler']}@afterCreate");
		Event::listen("eloquent.updating: {$a['AccessTask']}", "{$a['AccessTaskEventHandler']}@beforeUpdate");
		Event::listen("eloquent.updated: {$a['AccessTask']}", "{$a['AccessTaskEventHandler']}@afterUpdate");
		Event::listen("eloquent.deleting: {$a['AccessTask']}", "{$a['AccessTaskEventHandler']}@beforeDelete");
		Event::listen("eloquent.deleted: {$a['AccessTask']}", "{$a['AccessTaskEventHandler']}@afterDelete");
		Event::listen("eloquent.saving: {$a['AccessTask']}", "{$a['AccessTaskEventHandler']}@beforeSave");
		Event::listen("eloquent.saved: {$a['AccessTask']}", "{$a['AccessTaskEventHandler']}@afterSave");
	}

}