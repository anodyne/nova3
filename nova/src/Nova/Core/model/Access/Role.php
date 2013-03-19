<?php namespace Nova\Core\Model\Access;

use Model;
use UserModel;
use AccessTask;
use Cartalyst\Sentry\Groups\GroupInterface;

class Role extends Model implements GroupInterface {

	const INACTIVE		= 1;
	const USER			= 2;
	const ACTIVE		= 3;
	const POWERUSER		= 4;
	const ADMIN			= 5;
	const SYSADMIN		= 6;
	
	public $timestamps = false;

	protected $table = 'roles';
	
	protected static $properties = array(
		'id', 'name', 'desc', 'inherits',
	);

	/**
	 * Has Many: Users
	 */
	public function users()
	{
		return $this->hasMany('UserModel');
	}

	/**
	 * Belongs To Many: Tasks
	 */
	public function tasks()
	{
		return $this->belongsToMany('AccessTask', 'roles_tasks');
	}
	
	/**
	 * Get all the tasks.
	 *
	 * @return	Collection
	 */
	public function getTasks()
	{
		// Loop through this role's tasks
		foreach ($this->tasks as $task)
		{
			$groups[] = $task;
		}

		// If there are inherited roles, loop through those too
		if ( ! empty($this->inherits))
		{
			$inherited = explode(',', $this->inherits);

			foreach ($inherited as $i)
			{
				// Get a new instance of the model
				$instance = new static;

				// Start a new Query Builder
				$query = $instance->newQuery();	

				// Put the tasks into the holding array
				$groups[] = $query->find($i)->getTasks();
			}
		}

		return $this->newCollection($groups);
	}

	/*
	|--------------------------------------------------------------------------
	| Sentry Group Interface Methods
	|--------------------------------------------------------------------------
	|
	| Sentry provides an interface of methods that need to be implemented by
	| the model. In Nova's case, some of these aren't applicable, and in those
	| situations, we simply throw exceptions. In others, we do things the way
	| we've chosen to setup our authorization system.
	|
	*/

	/**
	 * Returns the group's ID.
	 *
	 * @return	int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Returns the group's name.
	 *
	 * @return	string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Returns permissions for the group included inherited permissions.
	 *
	 * @return	array
	 */
	public function getPermissions()
	{
		return $this->getTasks();
	}

}