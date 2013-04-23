<?php namespace Nova\Core\Model;

use Model;

class SystemEvent extends Model {

	protected $table = 'system_events';

	protected $fillable = array(
		'email', 'ip', 'user_id', 'character_id', 'content',
	);

	protected $dates = array('created_at', 'updated_at');
	
	protected static $properties = array(
		'id', 'email', 'ip', 'user_id', 'character_id', 'content', 
		'created_at', 'updated_at',
	);

}