<?php namespace Nova\Core\Models\Eloquent\User;

use Model;

class Loa extends Model {
	
	protected $table = 'user_loas';

	protected $fillable = array(
		'user_id', 'start_date', 'end_date', 'duration', 'reason',
		'type',
	);

	protected $dates = array('created_at', 'updated_at');
	
	protected static $properties = array(
		'id', 'user_id', 'start_date', 'end_date', 'duration', 'reason', 
		'type', 'created_at', 'updated_at',
	);

}