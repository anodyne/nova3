<?php namespace Nova\Core\Models\Eloquent\User;

use Model;

class Role extends Model {

	public $timestamps = false;
	
	protected $table = 'users_roles';

	protected $fillable = [
		'user_id', 'role_id',
	];
	
	protected static $properties = [
		'id', 'user_id', 'role_id',
	];

}