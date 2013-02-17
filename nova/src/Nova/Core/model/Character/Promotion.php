<?php
/**
 * Character Promotions Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model\Character;

class Promotion extends \Model {
	
	protected $table = 'character_promotions';
	
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
		'old_order' => array(
			'type' => 'int',
			'constraint' => 5,
			'null' => true),
		'old_rank' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
		'new_order' => array(
			'type' => 'int',
			'constraint' => 5,
			'null' => true),
		'new_rank' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
		'created_at' => array(
			'type' => 'datetime'),
	);
}
