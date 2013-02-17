<?php
/**
 * Character Positions Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model\Character;

class Positions extends \Model {
	
	protected $table = 'character_positions';
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'auto_increment' => true),
		'character_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'position_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'primary' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 0),
	);

	/**
	 * Get the records for character positions.
	 *
	 * @api
	 * @param	mixed	the ID to use or an array of conditions
	 * @param	string	the column to use (character_id, position_id)
	 * @return	object
	 */
	public static function getItems($value, $column = 'character_id')
	{
		if (is_array($value))
		{
			// start the find
			$query = static::query();

			// loop through the array of values and build the WHERE
			foreach ($value as $col => $val)
			{
				$query->where($col, $val);
			}

			return $query->get();
		}

		return static::query()->where($column, $value)->get();
	}
}
