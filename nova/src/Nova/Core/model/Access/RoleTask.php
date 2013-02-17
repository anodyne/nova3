<?php
/**
 * Access Roles-Tasks Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model\Access;

class RoleTask extends \Model {

	protected $table = 'roles_tasks';
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'role_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'task_id' => array(
			'type' => 'int',
			'constraint' => 11),
	);
}
