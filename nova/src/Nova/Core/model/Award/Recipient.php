<?php namespace Nova\Core\Model\Award;

use Model;
use UserModel;
use AwardModel;
use CharacterModel;

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
		return $this->belongsTo('AwardModel');
	}

	/**
	 * Belongs To: Character
	 */
	public function character()
	{
		return $this->belongsTo('CharacterModel');
	}

	/**
	 * Belongs To: User
	 */
	public function user()
	{
		return $this->belongsTo('UserModel');
	}

}