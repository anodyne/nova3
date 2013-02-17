<?php
/**
 * Access Task Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model\Access;

class Task extends \Model {

	protected $table = 'tasks';
	
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
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'component' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
		'action' => array(
			'type' => 'string',
			'constraint' => 11,
			'default' => 'read'),
		'level' => array(
			'type' => 'int',
			'constraint' => 2,
			'default' => 0),
		'dependencies' => array(
			'type' => 'text',
			'null' => true),
	);

	public static $_many_many = array(
		'roles' => array(
			'model_to' => '\\Model_Access_Role',
			'key_to' => 'id',
			'key_from' => 'id',
			'key_through_from' => 'task_id',
			'key_through_to' => 'role_id',
			'table_through' => 'roles_tasks',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	public static function getComponents()
	{
		return static::query()->group_by('component')->get();
	}

	public static function getTask($task)
	{
		// Break the task up into an array
		$taskArray = explode('.', $task);

		// Break the task up into its components
		list($component, $action, $level) = $taskArray;

		// Get a new instance of the model
		$instance = new static;

		// Start a new Query Builder
		$query = $instance->newQuery();

		return $query->where('component', $component)
			->where('action', $action)
			->where('level', $level)
			->first();
	}
}
