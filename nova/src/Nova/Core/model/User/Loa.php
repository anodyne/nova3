<?php namespace Nova\Core\Model\User;

use Model;

class Loa extends Model {
	
	protected $table = 'user_loas';
	
	protected static $_properties = array(
		'id', 'user_id', 'start_date', 'end_date', 'duration', 'reason', 
		'type', 'created_at', 'updated_at',
	);

}