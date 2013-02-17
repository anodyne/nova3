<?php
/**
 * User Suspension Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model\User;

class Suspend extends \Model {

	protected $table = 'user_suspended';
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'login_id' => array(
			'type' => 'string',
			'constraint' => 50),
		'attempts' => array(
			'type' => 'int',
			'constraint' => 50),
		'ip' => array(
			'type' => 'string',
			'constraint' => 16),
		'last_attempt_at' => array(
			'type' => 'datetime'),
		'suspended_at' => array(
			'type' => 'datetime',
			'null' => true),
		'unsuspend_at' => array(
			'type' => 'datetime',
			'null' => true),
	);

	/**
	 * Clear the user suspensions out.
	 *
	 * @api
	 * @param	array	the conditions to use
	 * @return 	void
	 */
	public static function clearItem(array $conditions)
	{
		// Get a new instance of the model
		$instance = new static;

		// Start a new Query Builder
		$query = $instance->newQuery();

		// Loop through all the conditions and build the find
		foreach ($conditions as $col => $val)
		{
			$query->where($col, $val);
		}

		$items = $query->get();

		// Delete the items
		$items->delete();
	}
}
