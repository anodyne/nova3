<?php
/**
 * Ban Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model;

class Ban extends \Model
{
	protected $table = 'bans';
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'level' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
		'ip_address' => array(
			'type' => 'string',
			'constraint' => 16,
			'null' => true),
		'email' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
		'reason' => array(
			'type' => 'text',
			'null' => true),
		'created_at' => array(
			'type' => 'datetime'),
	);

	/**
	 * Observers
	 */
	protected static $_observers = array(
		'Orm\\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => true,
		),
	);

	/**
	 * Get bans.
	 *
	 * @api
	 * @param	string	the value to use
	 * @param	string	the column to use
	 * @return	object
	 * @todo	should this be removed in favor of something else?
	 */
	public static function getItems($value, $column = 'email')
	{
		return static::query()->where($column, $value)->get();
	}
}
