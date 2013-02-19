<?php
/**
 * Announcements Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */
 
namespace Nova\Core\Model;

use Model;
use Status;
use UserModel;
use CommentModel;
use CharacterModel;
use AnnouncementCategoryModel;

class Announcement extends Model {

	protected $table = 'announcements';
	
	protected static $properties = array(
		'id'			=> array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
		'title'			=> array('type' => 'string', 'constraint' => 255, 'default' => ''),
		'user_id'		=> array('type' => 'int', 'constraint' => 11),
		'character_id'	=> array('type' => 'int', 'constraint' => 11),
		'category_id'	=> array('type' => 'int', 'constraint' => 11),
		'content'		=> array('type' => 'blob'),
		'status'		=> array('type' => 'tinyint', 'constraint' => 1, 'default' => Status::ACTIVE),
		'private'		=> array('type' => 'tinyint', 'constraint' => 1, 'default' => 0),
		'tags'			=> array('type' => 'text', 'null' => true),
		'created_at'	=> array('type' => 'datetime', 'null' => true),
		'updated_at'	=> array('type' => 'datetime', 'null' => true),
	);

	/**
	 * Belongs To: Announcement Category
	 */
	public function category()
	{
		return $this->belongsTo('AnnouncementCategoryModel');
	}

	/**
	 * Belongs To: Character
	 */
	public function character()
	{
		return $this->belongsTo('CharacterModel');
	}

	/**
	 * Belongs To: User
	 */
	public function user()
	{
		return $this->belongsTo('UserModel');
	}

	/**
	 * Polymorphic Relationship: Comments
	 */
	public function comments()
	{
		return $this->morphMany('CommentModel', 'commentable');
	}
}
