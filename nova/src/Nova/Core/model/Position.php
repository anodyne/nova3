<?php
/**
 * Position Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model;

class Position extends \Model
{
	protected $table = 'positions_';
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'desc' => array(
			'type' => 'text',
			'null' => true),
		'dept_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'order' => array(
			'type' => 'int',
			'constraint' => 5,
			'null' => true),
		'open' => array(
			'type' => 'int',
			'constraint' => 5,
			'default' => 1),
		'status' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => \Status::ACTIVE),
		'type' => array(
			'type' => 'enum',
			'constraint' => "'senior','officer','enlisted','other'",
			'default' => 'officer'),
	);
	
	/**
	 * Relationships
	 */
	protected static $_belongs_to = array(
		'dept' => array(
			'model_to' => '\\Model_Department',
			'key_to' => 'id',
			'key_from' => 'dept_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	protected static $_has_many = array(
		'applicants' => array(
			'model_to' => '\\Model_Application',
			'key_to' => 'position_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

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
	 * it in to the model. The _init method is necessary since PHP won't
	 * allow creating an object project that's dynamic. This method changes
	 * the name of the table once the class is loaded.
	 *
	 * @internal
	 * @return	void
	 */
	public static function _init()
	{
		static::$_table_name = static::$_table_name.\Config::get('nova.genre');
	}

	/**
	 * Get all characters for this position.
	 *
	 * @api
	 * @return	object
	 */
	public function getCharacters()
	{
		return \Model_Character_Positions::getItems($this->id, 'position_id');
	}
	
	/**
	 * Get positions based on criteria passed to the method.
	 *
	 * @api
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
	 * @api
	 * @param	string	the action being taken on the character (add, remove)
	 * @return	void
	 */
	public function updateAvailability($character_action)
	{
		if ($character_action == 'add')
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
