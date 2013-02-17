<?php
/**
 * System Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model;

class System extends \Model {

	protected $table = 'system_info';
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 1,
			'auto_increment' => true),
		'uid' => array(
			'type' => 'string',
			'constraint' => 32,
			'null' => true),
		'install_date' => array(
			'type' => 'datetime'),
		'last_update' => array(
			'type' => 'datetime',
			'null' => true),
		'version_major' => array(
			'type' => 'int',
			'constraint' => 1,
			'default' => 3),
		'version_minor' => array(
			'type' => 'int',
			'constraint' => 2),
		'version_update' => array(
			'type' => 'int',
			'constraint' => 4),
		'version_ignore' => array(
			'type' => 'string',
			'constraint' => 20,
			'null' => true),
	);
	
	/**
	 * Get the RPG unique identifier.
	 *
	 * @api
	 * @return	string
	 */
	public static function getUniqueId()
	{
		return static::find(1)->uid;
	}
	
	/**
	 * Update the system information.
	 *
	 * @api
	 * @param	array	the content to use in the update
	 * @return	object
	 */
	public static function updateInfo(array $data)
	{
		// Get the first record in the table
		$record = static::find(1);
		
		// Loop through the data we have and update the object
		foreach ($data as $key => $value)
		{
			$record->{$key} = $value;
		}
		
		// Save the record
		$record->save();
		
		return $record;
	}
}
