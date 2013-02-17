<?php
/**
 * Announcements Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model;

class Announcement extends \Model
{
	protected $table = 'announcements';
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'title' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'character_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'category_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'content' => array(
			'type' => 'blob'),
		'status' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => \Status::ACTIVE),
		'private' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 0),
		'tags' => array(
			'type' => 'text',
			'null' => true),
		'created_at' => array(
			'type' => 'datetime',
			'null' => true),
		'updated_at' => array(
			'type' => 'datetime',
			'null' => true),
	);
	
	/**
	 * Relationships
	 */
	public static $_belongs_to = array(
		'category' => array(
			'model_to' => '\\Model_AnnouncementCategory',
			'key_to' => 'id',
			'key_from' => 'category_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'character' => array(
			'model_to' => '\\Model_Character',
			'key_to' => 'id',
			'key_from' => 'character_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'user' => array(
			'model_to' => '\\Model_User',
			'key_to' => 'id',
			'key_from' => 'user_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	/**
	 * Observers
	 */
	protected static $_observers = array(
		'Orm\\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => true,
		),
		'Orm\\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => true,
		),
	);
	
	/**
	 * Get all the comments for an announcement.
	 *
	 * @api
	 * @param	string	the status of items to retrieve
	 * @return	object
	 */
	public function getComments($status = \Status::ACTIVE)
	{
		return \Model_Comment::find('all', array(
			'where' => array(
				array('type', 'announcement'),
				array('status', $status),
				array('item_id', $this->id)
			),
		));
	}
}
