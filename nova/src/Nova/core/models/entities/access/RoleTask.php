<?php namespace Nova\Core\Models\Entities\Access;

use Model;

class RoleTask extends Model {

	public $timestamps = false;
	
	protected $table = 'roles_tasks';

	protected $fillable = array(
		'role_id', 'task_id',
	);
	
	protected static $properties = array(
		'id', 'role_id', 'task_id',
	);

}