<?php namespace Nova\Core\Model\Post;

use Model;
use Post;

class Participant extends Model {

	public $timestamps = false;

	protected $table = 'post_participants';
	
	protected static $_properties = array(
		'id', 'post_id', 'user_id',
	);

	/**
	 * Belongs To: Post
	 */
	public function post()
	{
		return $this->belongsTo('Post');
	}

}