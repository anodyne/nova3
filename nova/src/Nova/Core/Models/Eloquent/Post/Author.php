<?php namespace Nova\Core\Models\Eloquent\Post;

use Model;

class Author extends Model {

	public $timestamps = false;

	protected $table = 'post_authors';

	protected $fillable = array(
		'post_id', 'character_id', 'user_id',
	);
	
	protected static $properties = array(
		'id', 'post_id', 'character_id', 'user_id',
	);

}