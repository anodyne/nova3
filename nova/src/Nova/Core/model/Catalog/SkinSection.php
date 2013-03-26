<?php namespace Nova\Core\Model\Catalog;

use Model;

class SkinSection extends Model {
	
	protected $table = 'catalog_skin_sections';

	protected $fillable = array(
		'section', 'skin', 'preview', 'status', 'default', 'nav',
	);
	
	protected static $properties = array(
		'id', 'section', 'skin', 'preview', 'status', 'default', 'nav',
		'created_at', 'updated_at',
	);
	
	/**
	 * Get the default skin section catalog item.
	 *
	 * @param	string	The section to pull
	 * @param	bool	Only return the location?
	 * @return	Section|string
	 */
	public static function getDefault($section, $valueOnly = false)
	{
		// Start a new Query Builder
		$query = static::startQuery();

		// Get the first item we find
		$result = $query->where('default', (int) true)->where('section', $section)->first();
		
		if ($valueOnly)
		{
			return $result->skin;
		}
		
		return $result;
	}

	/**
	 * Get all items from the catalog.
	 *
	 * @param	array	The arguments
	 * @param	bool	Return only the first item?
	 * @return	Collection|Section
	 */
	public static function getItems(array $arguments, $returnOne = false)
	{
		// Start a new Query Builder
		$query = static::startQuery();

		foreach ($arguments as $col => $val)
		{
			$query->where($col, $val);
		}

		if ($returnOne)
		{
			return $query->first();
		}

		return $query->get();
	}
	
}