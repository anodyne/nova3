<?php namespace Nova\Core\Models\Entities\Catalog;

use Model;
use Status;
use SkinCatalog as SkinCatalogModel;

class SkinSection extends Model {
	
	protected $table = 'catalog_skin_sections';

	protected $fillable = array(
		'section', 'skin', 'preview', 'status', 'default', 'nav',
	);

	protected $dates = array('created_at', 'updated_at');
	
	protected static $properties = array(
		'id', 'section', 'skin', 'preview', 'status', 'default', 'nav',
		'created_at', 'updated_at',
	);

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/

	/**
	 * Get the skin for this section.
	 *
	 * @return	Collection
	 */
	public function skin()
	{
		return SkinCatalogModel::where('location', $this->location)->active()->get();
	}

	/*
	|--------------------------------------------------------------------------
	| Model Methods
	|--------------------------------------------------------------------------
	*/
	
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