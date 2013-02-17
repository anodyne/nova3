<?php
/**
 * User Moderation Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model;

class Moderation extends \Model
{
	protected $table = 'moderation';
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 11,
			'null' => true),
		'character_id' => array(
			'type' => 'int',
			'constraint' => 11,
			'null' => true),
		'type' => array(
			'type' => 'string',
			'constraint' => 100,
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
}
