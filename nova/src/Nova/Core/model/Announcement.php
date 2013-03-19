<?php namespace Nova\Core\Model;

use Model;
use Status;
use User;
use Comment;
use Character;
use AnnouncementCategory;

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
		return $this->belongsTo('AnnouncementCategory');
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
		return $this->belongsTo('User');
	}

	/**
	 * Polymorphic Relationship: Comments
	 */
	public function comments()
	{
		return $this->morphMany('Comment', 'commentable');
	}

}