<?php
/**
 * Access Role Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model\Access;

class Role extends \Model {

	const INACTIVE		= 1;
	const USER			= 2;
	const ACTIVE		= 3;
	const POWERUSER		= 4;
	const ADMIN			= 5;
	const SYSADMIN		= 6;
	
	protected $table = 'roles';
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'desc' => array(
			'type' => 'text',
			'null' => true),
		'inherits' => array(
			'type' => 'text',
			'null' => true),
	);
	
	public static $_has_many = array(
		'users' => array(
			'model_to' => '\\Model_User',
			'key_to' => 'role_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	public static $_many_many = array(
		'tasks' => array(
			'model_to' => '\\Model_Access_Task',
			'key_to' => 'id',
			'key_from' => 'id',
			'key_through_from' => 'role_id',
			'key_through_to' => 'task_id',
			'table_through' => 'roles_tasks',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	/**
	 * Get all the roles.
	 *
	 * @api
	 * @param	array	Any items to remove from the final array
	 * @return	array
	 */
	public static function getRoles(array $remove = array())
	{
		$items = static::all();

		$roles = array();

		if (count($items) > 0)
		{
			foreach ($items as $r)
			{
				if ( ! in_array($r->id, $remove))
				{
					$roles[$r->id] = $r->name;
				}
			}
		}

		return $roles;
	}
	
	/**
	 * Get all the tasks.
	 *
	 * @api
	 * @return	array
	 */
	public function getTasks()
	{
		$groups[] = $this->tasks;
		
		$inherited = explode(',', $this->inherits);
		
		foreach ($inherited as $i)
		{
			//$groups[] = static::find($i)->getTasks();
			\Debug::dump(static::find($i));
		}
		
		return $groups;
	}
}
