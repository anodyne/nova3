<?php namespace Nova\Core\Models\Eloquent\Form;

use Event;
use Model;
use Config;
use Status;
use FormTrait;

class Field extends Model {

	use FormTrait;
	
	protected $table = 'form_fields';

	protected $fillable = array(
		'form_id', 'tab_id', 'section_id', 'type', 'label', 'order', 'status',
		'restriction', 'help', 'selected', 'value', 'html_id', 'html_class',
		'html_rows', 'placeholder', 'html_container_class', 'validation_rules',
	);

	protected $dates = array('created_at', 'updated_at');
	
	protected static $properties = array(
		'id', 'form_id', 'tab_id', 'section_id', 'type', 'label', 'order', 'status', 
		'restriction', 'help', 'selected', 'value', 'html_id', 'html_class',
		'html_rows', 'placeholder', 'html_container_class', 'validation_rules',
		'created_at', 'updated_at',
	);

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
		return $this->belongsTo('NovaForm', 'form_id');
	}

	/**
	 * Belongs To: Tab
	 */
	public function tab()
	{
		return $this->belongsTo('NovaFormTab', 'tab_id');
	}

	/**
	 * Belongs To: Section
	 */
	public function section()
	{
		return $this->belongsTo('NovaFormSection', 'section_id');
	}

	/**
	 * Has Many: Values
	 */
	public function values()
	{
		return $this->hasMany('NovaFormValue');
	}

	/**
	 * Has Many: Data
	 */
	public function data()
	{
		return $this->hasMany('NovaFormData');
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
	 * Boot the model and define the event listeners.
	 *
	 * @return	void
	 */
	public static function boot()
	{
		parent::boot();

		// Get all the aliases
		$a = Config::get('app.aliases');

		// Setup the listeners
		static::setupEventListeners($a['NovaFormField'], $a['FormFieldModelEventHandler']);
	}

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