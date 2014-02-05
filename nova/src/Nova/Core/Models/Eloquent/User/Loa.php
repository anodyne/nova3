<?php namespace Nova\Core\Models\Eloquent\User;

use Model;

class Loa extends Model {
	
	protected $table = 'users_loas';

	protected $fillable = [
		'user_id', 'start_date', 'end_date', 'duration', 'reason', 'type',
	];

	protected $dates = ['created_at', 'updated_at'];
	
	protected static $properties = [
		'id', 'user_id', 'start_date', 'end_date', 'duration', 'reason', 
		'type', 'created_at', 'updated_at',
	];

}