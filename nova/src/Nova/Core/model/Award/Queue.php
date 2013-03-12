<?php namespace Nova\Core\Model\Award;

use Model;

class Queue extends Model {
	
	protected $table = 'award_queue';
	
	protected static $properties = array(
		'id', 'receive_character_id', 'receive_user_id', 'nominate_character_id',
		'award_id', 'reason', 'status', 'created_at', 'updated_at',
	);

}