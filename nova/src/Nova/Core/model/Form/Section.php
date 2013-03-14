<?php namespace Nova\Core\Model\Form;

use Model;
use FormTabModel;
use FormFieldModel;

class Section extends Model {
	
	protected $table = 'form_sections';
	
	protected static $properties = array(
		'id', 'form_key', 'tab_id', 'name', 'order', 'status', 'created_at', 
		'updated_at',
	);

	/**
	 * Belongs To: Tab
	 */
	public function tab()
	{
		return $this->belongsTo('FormTabModel');
	}

	/**
	 * Has Many: Fields
	 */
	public function fields()
	{
		return $this->hasMany('FormFieldModel');
	}

	/**
	 * Observers
	 */
	protected static $_observers = array(
		'\\Form_Section' => array(
			'events' => array('before_delete', 'after_insert', 'after_update')
		),
	);

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