<?php namespace Nova\Core\Model;

use Model;
use Status;
use UserModel;
use CommentModel;
use Character;
use AnnouncementCategoryModel;

class Announcement extends Model {

	protected $table = 'announcements';
	
	protected static $properties = array(
		'id', 'title', 'user_id', 'character_id', 'category_id', 'content',
		'status', 'private', 'tags', 'created_at', 'updated_at',
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
		return $this->belongsTo('Character');
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