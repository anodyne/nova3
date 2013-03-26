<?php namespace Nova\Core\Model\Form;

use Model;
use Status;

class Field extends Model {
	
	protected $table = 'form_fields';

	protected $fillable = array(
		'form_key', 'section_id', 'type', 'label', 'order', 'status',
		'restriction', 'help', 'selected', 'value', 'html_name', 'html_id',
		'html_class', 'html_rows', 'placeholder',
	);
	
	protected static $properties = array(
		'id', 'form_key', 'section_id', 'type', 'label', 'order', 'status', 
		'restriction', 'help', 'selected', 'value', 'html_name', 'html_id', 
		'html_class', 'html_rows', 'placeholder', 'created_at', 'updated_at',
	);

	/**
	 * Belongs To: Section
	 */
	public function section()
	{
		return $this->belongsTo('NovaFormSection');
	}

	/**
	 * Has Many: Data
	 */
	public function data()
	{
		return $this->hasMany('NovaFormData');
	}

	/**
	 * Has Many: Values
	 */
	public function values()
	{
		return $this->hasMany('NovaFormValue');
	}

	/**
	 * Get fields.
	 *
	 * @param	string	The form key
	 * @param	int		The section ID
	 * @param	int		The status to pull
	 * @return	Collection
	 */
	public static function getItems($key, $section = false, $status = Status::ACTIVE)
	{
		// Start a new query
		$query = static::startQuery();
		$query->where('form_key', $key);

		if ($section !== false)
		{
			$query->where('section_id', $section);
		}

		if ($status !== false)
		{
			$query->where('status', $status);
		}

		return $query->orderBy('order', 'asc')->get();
	}

	/**
	 * Get any values for the current field. This is only used for
	 * select menus.
	 *
	 * @return	array
	 */
	public function getValues()
	{
		return $this->values->toSimpleArray('value', 'content');
	}

}