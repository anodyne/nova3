<?php namespace Nova\Core\Models\Entities\Form;

use Model;

class Value extends Model {
	
	protected $table = 'form_values';

	protected $fillable = array(
		'field_id', 'value', 'content', 'order',
	);

	protected $dates = array('created_at', 'updated_at');
	
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
	/*public static function getItems($field)
	{
		// Start a new query
		$query = static::startQuery();

		return $query->where('field_id', $field)->orderBy('order', 'asc')->get();
	}*/

}