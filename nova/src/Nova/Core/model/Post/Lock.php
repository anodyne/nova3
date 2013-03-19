<?php namespace Nova\Core\Model\Post;

use Model;
use Post;

class Lock extends Model {

	protected $table = 'post_locks';
	
	protected static $_properties = array(
		'id', 'post_id', 'user_id', 'created_at', 'updated_at',
	);

	/**
	 * Belongs To: Post
	 */
	public function post()
	{
		return $this->belongsTo('Post');
	}

}