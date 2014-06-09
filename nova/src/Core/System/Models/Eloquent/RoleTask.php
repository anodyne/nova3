<?php namespace Nova\Core\Models\Eloquent\Access;

use Model;

class RoleTask extends Model {

	public $timestamps = false;
	
	protected $table = 'roles_tasks';

	protected $fillable = [
		'role_id', 'task_id',
	];
	
	protected static $properties = [
		'id', 'role_id', 'task_id',
	];

}