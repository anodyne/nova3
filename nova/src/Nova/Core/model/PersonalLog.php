<?php
/**
 * Personal Logs Model
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

class PersonalLog extends Model {

	protected $table = 'personal_logs';
	
	protected static $properties = array(
		'id'			=> array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
		'title'			=> array('type' => 'string', 'constraint' => 255, 'null' => true),
		'user_id'		=> array('type' => 'int', 'constraint' => 11),
		'character_id'	=> array('type' => 'int', 'constraint' => 11),
		'content'		=> array('type' => 'text', 'null' => true),
		'status'		=> array('type' => 'tinyint', 'constraint' => 1, 'default' => Status::ACTIVE),
		'tags'			=> array('type' => 'text', 'null' => true),
		'created_at'	=> array('type' => 'datetime'),
		'updated_at'	=> array('type' => 'datetime', 'null' => true),
	);

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
