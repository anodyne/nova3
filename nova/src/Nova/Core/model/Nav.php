<?php namespace Nova\Core\Model;

use Model;
use Status;

class Nav extends Model {

	protected $table = 'navigation';
	
	protected static $properties = array(
		'id', 'name', 'group', 'order', 'url', 'url_target', 'needs_login', 
		'access', 'type', 'category', 'status', 'sim_type', 'created_at', 
		'updated_at',
	);

	/**
	 * Gets the nav items out of the database based on type and category.
	 *
	 * @param	string	The type of navigation (main, admin, sub, adminsub)
	 * @param	string	The category of navigation (main, personnel, sim, wiki)
	 * @param	int		The status to pull (null for all)
	 * @return	Collection
	 */
	public static function getItems($type, $category, $status = Status::ACTIVE)
	{
		// Start a new Query Builder
		$query = static::startQuery();

		if ( ! empty($type))
		{
			$query->where('type', $type);
		}

		if ( ! empty($category))
		{
			$query->where('category', $category);
		}

		if ($status !== false)
		{
			$query->where('status', $status);
		}

		return $query->orderBy('group', 'asc')->orderBy('order', 'asc')->get();
	}

}