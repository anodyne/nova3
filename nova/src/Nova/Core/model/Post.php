<?php
/**
 * Mission Posts Model
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
use MissionModel;
use CommentModel;
use CharacterModel;

class Post extends Model {

	protected $table = 'posts';
	
	protected static $properties = array(
		'id'			=> array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
		'title'			=> array('type' => 'string', 'constraint' => 255, 'null' => true),
		'location'		=> array('type' => 'string', 'constraint' => 255, 'null' => true),
		'timeline'		=> array('type' => 'string', 'constraint' => 255, 'null' => true),
		'mission_id'	=> array('type' => 'int', 'constraint' => 11),
		'saved_user_id'	=> array('type' => 'int', 'constriant' => 11, 'null' => true),
		'status'		=> array('type' => 'tinyint', 'constraint' => 1, 'default' => Status::ACTIVE),
		'content'		=> array('type' => 'text', 'null' => true),
		'tags'			=> array('type' => 'text', 'null' => true),
		'participants'	=> array('type' => 'text', 'null' => true),
		'lock_user_id'	=> array('type' => 'int', 'constraint' => 11, 'null' => true),
		'lock_date'		=> array('type' => 'datetime', 'null' => true),
		'created_at'	=> array('type' => 'datetime'),
		'updated_at'	=> array('type' => 'datetime', 'null' => true),
	);
	
	/**
	 * Belongs To: Mission
	 */
	public function mission()
	{
		return $this->belongsTo('MissionModel');
	}

	/**
	 * Belongs To Many: Users (through Post Authors)
	 */
	public function userAuthors()
	{
		return $this->belongsToMany('UserModel', 'post_authors');
	}

	/**
	 * Belongs To Many: Characters (through Post Authors)
	 */
	public function characterAuthors()
	{
		return $this->belongsToMany('CharacterModel', 'post_authors');
	}

	/**
	 * Polymorphic Relationship: Comments
	 */
	public function comments()
	{
		return $this->morphMany('CommentModel', 'commentable');
	}
	
	/**
	 * Display the authors for a mission post.
	 *
	 * @param	string	Type of authors to display (characters, users)
	 * @return	string
	 */
	public function showAuthors($type = 'characters')
	{
		$output = array();
		
		switch ($type)
		{
			case 'characters':
				foreach ($this->characterAuthors as $a)
				{
					$output[] = $a->getName();
				}
			break;
			
			case 'users':
				foreach ($this->userAuthors as $a)
				{
					$output[] = $a->name;
				}
			break;
		}
		
		return implode(' &amp; ', $output);
	}
}
