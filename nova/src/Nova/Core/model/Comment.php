<?php namespace Nova\Core\Model;

use Model;

class Comment extends Model {

	protected $table = 'comments';
	
	protected static $properties = array(
		'id', 'commentable_type', 'commentable_id', 'content', 'status', 
		'created_at', 'updated_at',
	);

	/**
	 * Polymorphic Relationship
	 */
	public function commentable()
	{
		return $this->morphTo();
	}

}