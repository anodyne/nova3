<?php
/**
 * System Event Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model;

class SystemEvent extends \Model
{
	protected $table = 'system_events';
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'auto_increment' => true),
		'email' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
		'ip' => array(
			'type' => 'string',
			'constraint' => 16),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 11,
			'null' => true),
		'character_id' => array(
			'type' => 'int',
			'constraint' => 11,
			'null' => true),
		'content' => array(
			'type' => 'text'),
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
}
