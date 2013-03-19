<?php namespace Nova\Core\Model\Access;

use Model;

class RoleTask extends Model {

	public $timestamps = false;
	
	protected $table = 'roles_tasks';
	
	protected static $properties = array(
		'id', 'role_id', 'task_id',
	);

}