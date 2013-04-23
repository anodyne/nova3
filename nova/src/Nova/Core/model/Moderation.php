<?php namespace Nova\Core\Model;

use Model;

class Moderation extends Model {

	protected $table = 'moderation';

	protected $fillable = array(
		'user_id', 'character_id', 'type',
	);

	protected $dates = array('created_at', 'updated_at');
	
	protected static $properties = array(
		'id', 'user_id', 'character_id', 'type', 'created_at', 'updated_at',
	);

}