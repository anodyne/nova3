<?php namespace Nova\Core\Model\Post;

use Model;

class Author extends Model {

	public $timestamps = false;

	protected $table = 'post_authors';
	
	protected static $_properties = array(
		'id', 'post_id', 'character_id', 'user_id',
	);

}