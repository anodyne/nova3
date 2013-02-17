<?php
/**
 * Nav Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model;

class Nav extends \Model {

	protected $table = 'navigation';
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'group' => array(
			'type' => 'int',
			'constraint' => 5,
			'null' => true),
		'order' => array(
			'type' => 'int',
			'constraint' => 5,
			'null' => true),
		'url' => array(
			'type' => 'text',
			'null' => true),
		'url_target' => array(
			'type' => 'enum',
			'constraint' => "'onsite','offsite'",
			'default' => 'onsite'),
		'needs_login' => array(
			'type' => 'enum',
			'constraint' => "'y','n','none'",
			'default' => 'none'),
		'access' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'type' => array(
			'type' => 'string',
			'constraint' => 50,
			'default' => 'main'),
		'category' => array(
			'type' => 'string',
			'constraint' => 20,
			'null' => true),
		'status' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => \Status::ACTIVE),
		'sim_type' => array(
			'type' => 'int',
			'constraint' => 5,
			'default' => 1),
	);

	/**
	 * Gets the nav items out of the database based on type and category.
	 *
	 * @api
	 * @param	string	the type of navigation (main, admin, sub, adminsub)
	 * @param	string	the category of navigation (main, personnel, sim, wiki)
	 * @param	int		the status to pull (null for all)
	 * @return	object
	 */
	public static function getItems($type, $category, $active = \Status::ACTIVE)
	{
		// Get a new instance of the model
		$instance = new static;

		// Start a new Query Builder
		$query = $instance->newQuery();

		if ( ! empty($type))
		{
			$query->where('type', $type);
		}

		if ( ! empty($category))
		{
			$query->where('category', $category);
		}

		if ($active !== null)
		{
			$query->where('status', (int) $active);
		}

		// set the ordering
		$query->orderBy('group', 'asc')->orderBy('order', 'asc');
		
		// run the query
		$items = $query->get();

		if (count($items) > 0)
		{
			return $items;
		}

		return false;
	}
}
