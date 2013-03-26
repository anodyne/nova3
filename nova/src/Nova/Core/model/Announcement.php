<?php namespace Nova\Core\Model;

use Model;
use Status;

class Announcement extends Model {

	protected $table = 'announcements';

	protected $fillable = array(
		'title', 'user_id', 'character_id', 'content', 'status',
		'private', 'keywords'
	);
	
	protected static $properties = array(
		'id', 'title', 'user_id', 'character_id', 'content', 'status',
		'private', 'keywords', 'created_at', 'updated_at',
	);

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

	/**
	 * Private Status Accessor.
	 *
	 * Converts the integer-based status field to a boolean.
	 *
	 * @param	string	The field value
	 * @return	bool
	 */
	public function getPrivateAttribute($value)
	{
		return (bool) $value;
	}

	/**
	 * Scope the query to activated announcements.
	 *
	 * @param	Builder		The query builder
	 * @return	void
	 */
	public function scopeActivated($query)
	{
		$query->where('status', Status::ACTIVE);
	}

	/**
	 * Scope the query to pending announcements.
	 *
	 * @param	Builder		The query builder
	 * @return	void
	 */
	public function scopePending($query)
	{
		$query->where('status', Status::PENDING);
	}

	/**
	 * Scope the query to saved announcements.
	 *
	 * @param	Builder		The query builder
	 * @return	void
	 */
	public function scopeSaved($query)
	{
		$query->where('status', Status::IN_PROGRESS);
	}

}