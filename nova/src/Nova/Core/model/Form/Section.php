<?php namespace Nova\Core\Model\Form;

use Model;

class Section extends Model {
	
	protected $table = 'form_sections';

	protected $fillable = array(
		'form_key', 'tab_id', 'name', 'order', 'status',
	);
	
	protected static $properties = array(
		'id', 'form_key', 'tab_id', 'name', 'order', 'status', 'created_at', 
		'updated_at',
	);

	/**
	 * Belongs To: Tab
	 */
	public function tab()
	{
		return $this->belongsTo('NovaFormTab');
	}

	/**
	 * Has Many: Fields
	 */
	public function fields()
	{
		return $this->hasMany('NovaFormField');
	}

	/**
	 * Get sections.
	 *
	 * @param	string	The form key
	 * @return	array
	 */
	public static function getItems($key)
	{
		// Start a new query
		$query = static::startQuery();

		$items = $query->where('form_key', $key)->orderBy('name', 'asc')->get();

		return $items->toSimpleArray();
	}

}