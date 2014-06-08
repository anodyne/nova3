<?php namespace Nova\Core\Models\Eloquent\Form;

use Model;
use FormTrait;

class Field extends Model {

	use FormTrait;
	
	protected $table = 'form_fields';

	protected $fillable = [
		'form_id', 'tab_id', 'section_id', 'type', 'label', 'order', 'status',
		'restriction', 'help', 'selected', 'value', 'html_id', 'html_class',
		'html_rows', 'placeholder', 'html_container_class', 'validation_rules',
	];

	protected $dates = ['created_at', 'updated_at'];
	
	protected static $properties = [
		'id', 'form_id', 'tab_id', 'section_id', 'type', 'label', 'order', 'status', 
		'restriction', 'help', 'selected', 'value', 'html_id', 'html_class',
		'html_rows', 'placeholder', 'html_container_class', 'validation_rules',
		'created_at', 'updated_at',
	];

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/

	/**
	 * Belongs To: Form
	 */
	public function form()
	{
		return $this->belongsTo('FormModel', 'form_id');
	}

	/**
	 * Belongs To: Tab
	 */
	public function tab()
	{
		return $this->belongsTo('FormTabModel', 'tab_id');
	}

	/**
	 * Belongs To: Section
	 */
	public function section()
	{
		return $this->belongsTo('FormSectionModel', 'section_id');
	}

	/**
	 * Has Many: Values
	 */
	public function values()
	{
		return $this->hasMany('FormValueModel');
	}

	/**
	 * Has Many: Data
	 */
	public function data()
	{
		return $this->hasMany('FormDataModel');
	}

	/*
	|--------------------------------------------------------------------------
	| Model Accessors
	|--------------------------------------------------------------------------
	*/

	public function getRestrictionAttribute($value)
	{
		return explode(',', $value);
	}

	public function setRestrictionAttribute($value)
	{
		$this->attributes['restriction'] = (is_array($value)) ? implode(',', $value) : $value;
	}

	/*
	|--------------------------------------------------------------------------
	| Model Scopes
	|--------------------------------------------------------------------------
	*/

	/**
	 * Scope the query to a specific field type.
	 *
	 * @param	Builder		The query builder
	 * @param	string		The field type
	 * @return	void
	 */
	public function scopeType($query, $type)
	{
		$query->where('type', $type);
	}

	/**
	 * Scope the query to dropdown menus.
	 *
	 * @param	Builder		The query builder
	 * @return	void
	 */
	public function scopeDropdowns($query)
	{
		$query->type('select');
	}

	/**
	 * Scope the query to text fields.
	 *
	 * @param	Builder		The query builder
	 * @return	void
	 */
	public function scopeText($query)
	{
		$query->type('text');
	}

	/**
	 * Scope the query to textarea fields.
	 *
	 * @param	Builder		The query builder
	 * @return	void
	 */
	public function scopeTextarea($query)
	{
		$query->type('textarea');
	}

	/*
	|--------------------------------------------------------------------------
	| Model Methods
	|--------------------------------------------------------------------------
	*/

	/**
	 * Get any values for the current field. This is only used for
	 * select menus.
	 *
	 * @return	array
	 */
	public function getValues()
	{
		return $this->values->sortBy(function($v)
		{
			return $v->order;
		})->toSimpleArray('value', 'value');
	}

}