<?php namespace Nova\Core\Model\Form;

use Model;

class Tab extends Model {
	
	protected $table = 'form_tabs';

	protected $fillable = array(
		'form_key', 'name', 'link_id', 'order', 'status',
	);
	
	protected static $properties = array(
		'id', 'form_key', 'name', 'link_id', 'order', 'status', 'created_at', 
		'updated_at',
	);

	/**
	 * Has Many: Sections
	 */
	public function sections()
	{
		return $this->hasMany('NovaFormSection');
	}

	/**
	 * Get tabs.
	 *
	 * @param	string	The form key
	 * @return	array
	 */
	public static function getItems($key)
	{
		// Start a new query
		$query = static::startQuery();

		// Get the items
		$items = $query->where('form_key', $key)->orderBy('name', 'asc')->get();

		return $items->toSimpleArray();
	}

}