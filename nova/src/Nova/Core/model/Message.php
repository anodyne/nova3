<?php namespace Nova\Core\Model;

use Model;

class Message extends Model {

	protected $table = 'messages';

	protected $fillable = array(
		'user_id', 'character_id', 'subject', 'content', 'status',
	);

	protected $dates = array('created_at', 'updated_at');
	
	protected static $properties = array(
		'id', 'user_id', 'character_id', 'subject', 'content', 'status', 
		'created_at', 'updated_at',
	);

	/**
	 * Has Many: Messages
	 */
	public function messages()
	{
		return $this->hasMany('MessageRecipient');
	}

}