<?php namespace Nova\Core\Model\Post;

use Model;

class Lock extends Model {

	protected $table = 'post_locks';

	protected $fillable = array(
		'post_id', 'user_id',
	);

	protected $dates = array('created_at', 'updated_at');
	
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