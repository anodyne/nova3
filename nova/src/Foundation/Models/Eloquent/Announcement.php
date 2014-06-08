<?php namespace Nova\Core\Models\Eloquent;

use Model;
use Status;

class Announcement extends Model {

	protected $table = 'announcements';

	protected $fillable = array(
		'title', 'user_id', 'character_id', 'content', 'status',
		'private', 'keywords'
	);

	protected $dates = array('created_at', 'updated_at');
	
	protected static $properties = array(
		'id', 'title', 'user_id', 'character_id', 'content', 'status',
		'private', 'keywords', 'created_at', 'updated_at',
	);

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/

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

	/*
	|--------------------------------------------------------------------------
	| Accessors and Mutators
	|--------------------------------------------------------------------------
	*/

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

	/*
	|--------------------------------------------------------------------------
	| Model Scopes
	|--------------------------------------------------------------------------
	*/

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