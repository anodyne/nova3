<?php
/**
 * Wiki Draft Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Wiki_Draft extends \Model
{
	public static $_table_name = 'wiki_drafts';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'id_old' => array(
			'type' => 'int',
			'constraint' => 11,
			'null' => true),
		'title' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'character_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'summary' => array(
			'type' => 'text',
			'null' => true),
		'content' => array(
			'type' => 'text',
			'null' => true),
		'page_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'created_at' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'categories' => array(
			'type' => 'text',
			'null' => true),
		'change_comments' => array(
			'type' => 'text',
			'null' => true),
	);
}
