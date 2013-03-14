<?php namespace Nova\Core\Model;

use Model;
use MessageModel;

class MessageRecipient extends Model {

	protected $table = 'message_recipients';
	
	protected static $properties = array(
		'id', 'message_id', 'user_id', 'character_id', 'unread', 'status', 
		'created_at', 'updated_at',
	);

	/**
	 * Belongs To: Message
	 */
	public function message()
	{
		return $this->hasMany('MessageModel');
	}

}