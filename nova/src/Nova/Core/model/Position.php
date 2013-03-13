<?php namespace Nova\Core\Model;

use Model;
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
	 * @param	string	the scope of the positions to pull (all, open)
	 * @param	int		the department to pull (works for all scopes)
	 * @param	bool	whether to show displayed positions or not (null for both)
	 * @return	object
	 */
	public static function getItems($scope = 'all', $dept = null, $active = true)
	{
		// grab the genre
		$genre = \Config::get('nova.genre');

		$query = static::query();
		
		if ( ! empty($active))
		{
			$query->where('status', \Status::ACTIVE);
		}
		
		switch ($scope)
		{
			case 'all_playing':
				$query->related('dept')->where('dept.type', 'playing');
			break;

			case 'all_nonplaying':
				$query->related('dept')->where('dept.type', 'nonplaying');
			break;

			case 'open':
				$query->where('open', '>', 0);
			break;

			case 'open_playing':
				$query->related('dept')
					->where('dept.type', 'playing')
					->where('open', '>', 0);
			break;

			case 'open_nonplaying':
				$query->related('dept')
					->where('dept.type', 'nonplaying')
					->where('open', '>', 0);
			break;
		}
		
		if ( ! empty($dept) and is_numeric($dept))
		{
			$query->where('dept_id', $dept);
		}
		
		// we should always be using the dept and order to order the results
		$query->order_by('dept_id', 'asc');
		$query->order_by('order', 'asc');
		
		return $query->get();
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