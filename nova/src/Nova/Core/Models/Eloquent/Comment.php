<?php namespace Nova\Core\Models\Eloquent;

use Event;
use Model;
use Config;

class Comment extends Model {

	protected $table = 'comments';

	protected $fillable = array(
		'content', 'status', 'commentable_type', 'commentable_id'
	);

	protected $dates = array('created_at', 'updated_at');
	
	protected static $properties = array(
		'id', 'commentable_type', 'commentable_id', 'content', 'status', 
		'created_at', 'updated_at',
	);

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/

	/**
	 * Polymorphic Relationship
	 */
	public function commentable()
	{
		return $this->morphTo();
	}

	/*
	|--------------------------------------------------------------------------
	| Model Methods
	|--------------------------------------------------------------------------
	*/

	/**
	 * Boot the model and define the event listeners.
	 *
	 * @return	void
	 */
	public static function boot()
	{
		parent::boot();

		// Get all the aliases
		$a = Config::get('app.aliases');

		// Setup the listeners
		static::setupEventListeners($a['Comment'], $a['CommentModelEventHandler']);
	}

}