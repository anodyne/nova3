<?php namespace Nova\Core\Model\Form;

use Event;
use Model;
use Config;
use Status;

class Field extends Model {
	
	protected $table = 'form_fields';

	protected $fillable = array(
		'form_key', 'section_id', 'type', 'label', 'order', 'status',
		'restriction', 'help', 'selected', 'value', 'html_name', 'html_id',
		'html_class', 'html_rows', 'placeholder',
	);

	protected $dates = array('created_at', 'updated_at');
	
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

	/*
	|--------------------------------------------------------------------------
	| Model Methods
	|--------------------------------------------------------------------------
	*/

	/**
	 * Boot the model and define the event listeners.
	 *
	 * @return	void
	 */
	public static function boot()
	{
		parent::boot();

		// Get all the aliases
		$classes = Config::get('app.aliases');

		Event::listen("eloquent.created: {$classes['NovaFormField']}", "{$classes['NovaFormFieldHandler']}@afterCreate");
		Event::listen("eloquent.updated: {$classes['NovaFormField']}", "{$classes['NovaFormFieldHandler']}@afterUpdate");
		Event::listen("eloquent.deleting: {$classes['NovaFormField']}", "{$classes['NovaFormFieldHandler']}@beforeDelete");
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