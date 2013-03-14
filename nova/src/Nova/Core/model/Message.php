<?php namespace Nova\Core\Model;

use Model;
use MessageRecipientModel;

class Message extends Model {

	protected $table = 'messages';
	
	protected static $properties = array(
		'id', 'user_id', 'character_id', 'subject', 'content', 'status', 
		'created_at', 'updated_at',
	);

	/**
	 * Has Many: Messages
	 */
	public function messages()
	{
		return $this->hasMany('MessageRecipientModel');
	}

}