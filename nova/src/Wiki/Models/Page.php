<?php
/**
 * Wiki Page Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Wiki_Page extends \Model
{
	public static $_table_name = 'wiki_pages';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'draft_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'created_at' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'created_by_user' => array(
			'type' => 'int',
			'constraint' => 11),
		'created_by_character' => array(
			'type' => 'int',
			'constraint' => 11),
		'updated_at' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'null' => true),
		'updated_by_user' => array(
			'type' => 'int',
			'constraint' => 11),
		'updated_by_character' => array(
			'type' => 'int',
			'constraint' => 11),
		'comments' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
		'type' => array(
			'type' => 'enum',
			'constraint' => "'standard','system'",
			'default' => 'standard'),
		'key' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
	);

	/**
	 * Polymorphic Relationship: Comments
	 */
	public function comments()
	{
		return $this->morphMany('CommentModel', 'commentable');
	}

	/**
	 * Get all the comments for a wiki page.
	 *
	 * @api
	 * @param	string	the status of items to retrieve
	 * @return	object
	 */
	public function getComments($status = 'activated')
	{
		return \CommentModel::find('all', array(
			'where' => array(
				array('type', 'wiki'),
				array('status', $status),
				array('item_id', $this->id)
			),
		));
	}
}
