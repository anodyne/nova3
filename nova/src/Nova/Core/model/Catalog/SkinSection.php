<?php namespace Nova\Core\Model\Catalog;

use Model;
use SkinCatalog as SkinCatalogModel;

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
	 * Get the skin for this section.
	 *
	 * @return	Collection
	 */
	public function skin()
	{
		return SkinCatalogModel::getItems(array('location' => $this->location));
	}

	/**
	 * Scope the query to active items.
	 *
	 * @param	Builder		The query builder
	 * @return	void
	 */
	public function scopeActive($query)
	{
		$query->where('status', Status::ACTIVE);
	}

	/**
	 * Scope the query to inactive items.
	 *
	 * @param	Builder		The query builder
	 * @return	void
	 */
	public function scopeInactive($query)
	{
		$query->where('status', Status::INACTIVE);
	}
	
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
	
}