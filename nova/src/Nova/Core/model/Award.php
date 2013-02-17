<?php
/**
 * Award Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model;

class Award extends \Model
{
	protected $table = 'awards';
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'image' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
		'category_id' => array(
			'type' => 'int',
			'constraint' => 11,
			'null' => true),
		'order' => array(
			'type' => 'int',
			'constraint' => 5,
			'null' => true),
		'desc' => array(
			'type' => 'text',
			'null' => true),
		'type' => array(
			'type' => 'enum',
			'constraint' => "'ic','ooc','both'",
			'default' => 'ic'),
		'status' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => \Status::ACTIVE),
	);

	/**
	 * Relationships
	 */
	public static $_belongs_to = array(
		'category' => array(
			'model_to' => '\\Model_Award_Category',
			'key_to' => 'id',
			'key_from' => 'category_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
}
