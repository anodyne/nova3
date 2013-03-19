<?php namespace Nova\Core\Model\Form;

use Model;
use NovaFormData;
use NovaFormField;

class Value extends Model {
	
	protected $table = 'form_values';
	
	protected static $properties = array(
		'id', 'field_id', 'value', 'content', 'order', 'created_at', 'updated_at',
	);

	/**
	 * Belongs To: Field
	 */
	public function section()
	{
		return $this->belongsTo('NovaFormField');
	}

	/**
	 * Has Many: Data
	 */
	public function data()
	{
		return $this->hasMany('NovaFormData');
	}

	/**
	 * Get values.
	 *
	 * @param	int		The field ID
	 * @return	Collection
	 */
	public static function getItems($field)
	{
		// Start a new query
		$query = static::startQuery();

		return $query->where('field_id', $field)->orderBy('order', 'asc')->get();
	}

}