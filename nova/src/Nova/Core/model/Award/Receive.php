<?php namespace Nova\Core\Model\Award;

use Model;

class Receive extends Model {
	
	protected $table = 'award_received';
	
	protected static $properties = array(
		'id', 'receive_character_id', 'receive_user_id', 'nominate_character_id', 
		'award_id', 'reason', 'created_at', 'updated_at',
	);

}