<?php namespace Nova\Core\Model\Catalog;

use Model;

class SkinSection extends Model {
	
	protected $table = 'catalog_skin_sections';
	
	protected static $properties = array(
		'id', 'section', 'skin', 'preview', 'status', 'default', 'nav',
		'created_at', 'updated_at',
	);
	
	/**
	 * Relationships
	 */
	public static $_belongs_to = array(
		'skins' => array(
			'model_to' => '\\Model_Catalog_Skin',
			'key_to' => 'location',
			'key_from' => 'skin',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
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

		$query->where(array('default', (int) true))
			->where(array('section', $section))
			->first();
		
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