<?php namespace Nova\Core\Models\Entities\Post;

use Model;

class Participant extends Model {

	public $timestamps = false;

	protected $table = 'post_participants';

	protected $fillable = array(
		'post_id', 'user_id',
	);
	
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