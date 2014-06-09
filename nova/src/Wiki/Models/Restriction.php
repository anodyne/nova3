<?php
/**
 * Wiki Restriction Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Wiki_Restriction extends \Model
{
	public static $_table_name = 'wiki_restrictions';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'page_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'created_at' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'created_by' => array(
			'type' => 'int',
			'constraint' => 11),
		'updated_at' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'null' => true),
		'updated_by' => array(
			'type' => 'int',
			'constraint' => 11,
			'null' => true),
		'restrictions' => array(
			'type' => 'text',
			'null' => true),
	);
}
