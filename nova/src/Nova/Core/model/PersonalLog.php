<?php namespace Nova\Core\Model;

use Model;
use UserModel;
use CommentModel;
use CharacterModel;

class PersonalLog extends Model {

	protected $table = 'personal_logs';
	
	protected static $properties = array(
		'id', 'title', 'user_id', 'character_id', 'content', 'status', 'tags', 
		'created_at', 'updated_at',
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