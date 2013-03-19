<?php namespace Nova\Core\Model\Award;

use Model;
use User;
use Award;
use Character;

class Recipient extends Model {
	
	protected $table = 'award_recipients';
	
	protected static $properties = array(
		'id', 'character_id', 'user_id', 'sender_user_id', 'award_id', 'reason', 
		'status', 'created_at', 'updated_at',
	);

	/**
	 * Belongs To: Award
	 */
	public function award()
	{
		return $this->belongsTo('Award');
	}

	/**
	 * Belongs To: Character
	 */
	public function character()
	{
		return $this->belongsTo('Character');
	}

	/**
	 * Belongs To: User
	 */
	public function user()
	{
		return $this->belongsTo('User');
	}

}