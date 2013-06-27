<?php namespace Nova\Core\Models\Entities\Form;

use Event;
use Model;
use Config;
use Status;
use FormTrait;

class Field extends Model {

	use FormTrait;
	
	protected $table = 'form_fields';

	protected $fillable = array(
		'form_id', 'section_id', 'type', 'label', 'order', 'status',
		'restriction', 'help', 'selected', 'value', 'html_name', 'html_id',
		'html_class', 'html_rows', 'placeholder',
	);

	protected $dates = array('created_at', 'updated_at');
	
	protected static $properties = array(
		'id', 'form_id', 'section_id', 'type', 'label', 'order', 'status', 
		'restriction', 'help', 'selected', 'value', 'html_name', 'html_id', 
		'html_class', 'html_rows', 'placeholder', 'created_at', 'updated_at',
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

		Event::listen("eloquent.creating: {$a['NovaFormField']}", "{$a['FormFieldEventHandler']}@beforeCreate");
		Event::listen("eloquent.created: {$a['NovaFormField']}", "{$a['FormFieldEventHandler']}@afterCreate");
		Event::listen("eloquent.updating: {$a['NovaFormField']}", "{$a['FormFieldEventHandler']}@beforeUpdate");
		Event::listen("eloquent.updated: {$a['NovaFormField']}", "{$a['FormFieldEventHandler']}@afterUpdate");
		Event::listen("eloquent.deleting: {$a['NovaFormField']}", "{$a['FormFieldEventHandler']}@beforeDelete");
		Event::listen("eloquent.deleted: {$a['NovaFormField']}", "{$a['FormFieldEventHandler']}@afterDelete");
		Event::listen("eloquent.saving: {$a['NovaFormField']}", "{$a['FormFieldEventHandler']}@beforeSave");
		Event::listen("eloquent.saved: {$a['NovaFormField']}", "{$a['FormFieldEventHandler']}@afterSave");
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