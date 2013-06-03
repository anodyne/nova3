<?php
/**
 * Wiki Category Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Wiki_Category extends \Model
{
	public static $_table_name = 'wiki_categories';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
		'desc' => array(
			'type' => 'text',
			'null' => true),
	);
}
