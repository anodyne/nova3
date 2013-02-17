<?php
/**
 * Character Images Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model\Character;

class Image extends \Model {
	
	protected $table = 'character_images';
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'auto_increment' => true),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'character_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'image' => array(
			'type' => 'text',
			'null' => true),
		'primary_image' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 0),
		'created_by' => array(
			'type' => 'int',
			'constraint' => 11),
		'created_at' => array(
			'type' => 'bigint',
			'constraint' => 20),
	);
}
