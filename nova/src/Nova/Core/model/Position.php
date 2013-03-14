<?php namespace Nova\Core\Model;

use Str;
use Model;
use Config;
use Status;
use DeptModel;
use CharacterModel;
use ApplicationModel;

class Position extends Model {

	protected $table = 'positions_';
	
	protected static $properties = array(
		'id', 'name', 'desc', 'dept_id', 'order', 'open', 'status', 'type', 
		'created_at', 'updated_at',
	);

	/**
	 * Belongs To: Department
	 */
	public function dept()
	{
		return $this->belongsTo('DeptModel');
	}

	/**
	 * Has Many: Applicants
	 */
	public function applicants()
	{
		return $this->hasMany('ApplicationModel');
	}

	/**
	 * Belongs To Many: Characters (through Character Positions)
	 */
	public function characters()
	{
		return $this->belongsToMany('CharacterModel', 'character_positions');
	}

	/**
	 * Observers
	 */
	protected static $_observers = array(
		'\\Position' => array(
			'events' => array('before_delete', 'after_insert', 'after_update')
		),
	);

	/**
	 * Since the table name is appended with the genre, we can't hard-code
	 * it in to the model. When the object is created, we have to pull the
	 * genre out of the config and name the table.
	 *
	 * @internal
	 * @return	void
	 */
	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);

		// Set the name of the table
		$this->setTable('positions_'.Config::get('nova.genre'));
	}
	
	/**
	 * Get positions based on criteria passed to the method.
	 *
	 * @param	string	A dot-delimited scope (all/open.playing/nonplaying)
	 * @param	int		The department ID to pull from
	 * @param	int		What status of positions to show
	 * @return	Collection
	 */
	public static function getItems($scope = 'all', $dept = false, $status = Status::ACTIVE)
	{
		// Grab the genre
		$genre = Config::get('nova.genre');

		// Start a new query
		$items = static::startQuery();
		
		// Set the status we're looking for
		if ($status !== false)
		{
			$items = $items->where("positions_{$genre}.status", $status);
		}

		// Set the department we're looking for
		if ($dept !== false and (is_numeric($dept)) and $dept > 0)
		{
			$items = $items->where("positions_{$genre}.dept_id", $dept);
		}

		if (Str::contains($scope, '.'))
		{
			// If we've got a period, we'll split at the period
			list($scope, $type) = explode('.', $scope);
		}
		else
		{
			// With no period, we'll make the scope the type as well
			$type = $scope;
		}

		// Narrow the results based on the scope (all/open)
		switch ($scope)
		{
			case 'open':
				$items = $items->where("positions_{$genre}.open", '>', 0);
			break;
		}

		// Join the departments table to pull only positions from certain types of departments
		switch ($type)
		{
			case 'playing':
			case 'nonplaying':
				$items = $items->join("departments_{$genre}", function($join) use($genre)
						{
							$join->on("positions_{$genre}.dept_id", '=', "departments_{$genre}.id");
						})
					->where("departments_{$genre}.type", $type)
					->select("positions_{$genre}.*");
			break;
		}

		return $items->orderBy("positions_{$genre}.dept_id", 'asc')
			->orderBy("positions_{$genre}.order", 'asc')
			->get();
	}

	/**
	 * Update the open slots for the position.
	 *
	 * @param	string	The action being taken on the character (add, remove)
	 * @return	void
	 */
	public function updatePositionAvailability($action)
	{
		if ($action == 'add')
		{
			$this->open = --$this->open;
		}
		else
		{
			$this->open = ++$this->open;
		}

		$this->save();
	}

}