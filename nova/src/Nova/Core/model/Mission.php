<?php
/**
 * Missions Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model;

class Mission extends \Model
{
	protected $table = 'missions';
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'title' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'images' => array(
			'type' => 'text',
			'null' => true),
		'order' => array(
			'type' => 'int',
			'constraint' => 5,
			'null' => true),
		'group_id' => array(
			'type' => 'int',
			'constraint' => 11,
			'null' => true),
		'status' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => \Status::PENDING),
		'start_date' => array(
			'type' => 'datetime',
			'null' => true),
		'end_date' => array(
			'type' => 'datetime',
			'null' => true),
		'desc' => array(
			'type' => 'text',
			'null' => true),
		'summary' => array(
			'type' => 'text',
			'null' => true),
		'notes' => array(
			'type' => 'text',
			'null' => true),
		'notes_updated_at' => array(
			'type' => 'datetime',
			'null' => true),
	);
	
	/**
	 * Relationships
	 */
	public static $_belongs_to = array(
		'group' => array(
			'model_to' => '\\Model_MissionGroup',
			'key_to' => 'id',
			'key_from' => 'group_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	public static $_has_many = array(
		'posts' => array(
			'model_to' => '\\Model_Post',
			'key_to' => 'mission_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
}
