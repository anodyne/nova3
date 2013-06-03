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
		$classes = Config::get('app.aliases');

		// Create event
		Event::listen(
			"eloquent.creating: {$classes['AccessTask']}",
			"{$classes['AccessTaskEventHandler']}@beforeCreate"
		);
		Event::listen(
			"eloquent.created: {$classes['AccessTask']}",
			"{$classes['AccessTaskEventHandler']}@afterCreate"
		);

		// Update Event
		Event::listen(
			"eloquent.updating: {$classes['AccessTask']}",
			"{$classes['AccessTaskEventHandler']}@beforeUpdate"
		);
		Event::listen(
			"eloquent.updated: {$classes['AccessTask']}",
			"{$classes['AccessTaskEventHandler']}@afterUpdate"
		);

		// Delete events
		Event::listen(
			"eloquent.deleting: {$classes['AccessTask']}",
			"{$classes['AccessTaskEventHandler']}@beforeDelete"
		);
		Event::listen(
			"eloquent.deleted: {$classes['AccessTask']}",
			"{$classes['AccessTaskEventHandler']}@afterDelete"
		);

		// Save events
		Event::listen(
			"eloquent.saving: {$classes['AccessTask']}",
			"{$classes['AccessTaskEventHandler']}@beforeSave"
		);
		Event::listen(
			"eloquent.saved: {$classes['AccessTask']}",
			"{$classes['AccessTaskEventHandler']}@afterSave"
		);
	}

}