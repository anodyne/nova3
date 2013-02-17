<?php
/**
 * Media Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model;

class Media extends \Model
{
	protected $table = 'media';
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'auto_increment' => true),
		'filename' => array(
			'type' => 'text',
			'null' => true),
		'mime_type' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'resource_type' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'ip_address' => array(
			'type' => 'string',
			'constraint' => 16),
		'created_at' => array(
			'type' => 'datetime'),
		'updated_at' => array(
			'type' => 'datetime',
			'null' => true),
	);

	/**
	 * Observers
	 */
	protected static $_observers = array(
		'Orm\\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => true,
		),
		'Orm\\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => true,
		),
	);
}
