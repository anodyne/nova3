<?php namespace Nova\Core\Models\Entities;

use Model;
use Status;

class Post extends Model {

	protected $table = 'posts';

	protected $fillable = array(
		'title', 'location', 'timeline', 'mission_id', 'saved_user_id',
		'status', 'content', 'keywords',
	);

	protected $dates = array('created_at', 'updated_at');
	
	protected static $properties = array(
		'id', 'title', 'location', 'timeline', 'mission_id', 'saved_user_id', 
		'status', 'content', 'keywords', 'created_at', 'updated_at',
	);

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/
	
	/**
	 * Belongs To: Mission
	 */
	public function mission()
	{
		return $this->belongsTo('Mission');
	}

	/**
	 * Has One: Post Lock
	 */
	public function lock()
	{
		return $this->hasOne('PostLock');
	}

	/**
	 * Has Many: Post Participants
	 */
	public function participants()
	{
		return $this->hasMany('PostParticipant');
	}

	/**
	 * Belongs To Many: Users (through Post Authors)
	 */
	public function userAuthors()
	{
		return $this->belongsToMany('User', 'post_authors');
	}

	/**
	 * Belongs To Many: Characters (through Post Authors)
	 */
	public function characterAuthors()
	{
		return $this->belongsToMany('Character', 'post_authors');
	}

	/**
	 * Polymorphic Relationship: Comments
	 */
	public function comments()
	{
		return $this->morphMany('Comment', 'commentable');
	}

	/*
	|--------------------------------------------------------------------------
	| Model Methods
	|--------------------------------------------------------------------------
	*/
	
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