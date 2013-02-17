<?php
/**
 * Mission Groups Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model;

class MissionGroup extends \Model
{
	protected $table = 'mission_groups';
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'order' => array(
			'type' => 'int',
			'constraint' => 5,
			'null' => true),
		'desc' => array(
			'type' => 'text',
			'null' => true),
		'parent_id' => array(
			'type' => 'int',
			'constraint' => 11,
			'null' => true),
	);
	
	/**
	 * Relationships
	 */
	public static $_has_many = array(
		'missions' => array(
			'model_to' => '\\Model_Mission',
			'key_to' => 'group_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
}
