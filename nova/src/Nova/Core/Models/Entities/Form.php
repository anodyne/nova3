<?php namespace Nova\Core\Models\Entities;

use Event;
use Model;
use Config;
use Status;
use FormTrait;

class Form extends Model {

	use FormTrait;

	protected $table = 'forms';

	protected $fillable = array(
		'key', 'name', 'orientation', 'status', 'form_viewer', 'email_allowed',
		'email_addresses', 'data_model', 'form_viewer_message', 'form_viewer_display',
	);

	protected $dates = array('created_at', 'updated_at');
	
	protected static $properties = array(
		'id', 'key', 'name', 'orientation', 'status', 'protected', 'form_viewer',
		'email_allowed', 'email_addresses', 'data_model', 'form_viewer_message',
		'form_viewer_display', 'created_at', 'updated_at',
	);

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/
	
	/**
	 * Has Many: Tabs
	 */
	public function tabs()
	{
		return $this->hasMany('NovaFormTab', 'form_id')->orderAsc('order');
	}

	/**
	 * Has Many: Sections
	 */
	public function sections()
	{
		return $this->hasMany('NovaFormSection', 'form_id')->orderAsc('order');
	}

	/**
	 * Has Many: Fields
	 */
	public function fields()
	{
		return $this->hasMany('NovaFormField', 'form_id')->orderAsc('order');
	}

	/**
	 * Has Many: Data
	 */
	public function data()
	{
		return $this->hasMany('NovaFormData', 'form_id')->orderAsc('field_id');
	}

	/*
	|--------------------------------------------------------------------------
	| Model Scopes
	|--------------------------------------------------------------------------
	*/

	/**
	 * Scope the query to forms allowing form viewer.
	 *
	 * @param	Builder		The query builder
	 * @return	void
	 */
	public function scopeFormViewer($query)
	{
		$query->where('form_viewer', (int) true);
	}

	/**
	 * Scope the query to protected forms.
	 *
	 * @param	Builder		The query builder
	 * @return	void
	 */
	public function scopeProtected($query)
	{
		$query->where('protected', (int) true);
	}

	/**
	 * Scope the query to unprotected forms.
	 *
	 * @param	Builder		The query builder
	 * @return	void
	 */
	public function scopeUnprotected($query)
	{
		$query->where('protected', (int) false);
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
		static::setupEventListeners($a['NovaForm'], $a['NovaFormEventHandler']);
	}

	/**
	 * Get the field validation rules for the form.
	 *
	 * @return	array
	 */
	public function getFieldValidationRules()
	{
		$rules = [];

		if ($this->fields->count() > 0)
		{
			foreach ($this->fields as $field)
			{
				if ( ! empty($field->validation_rules))
				{
					$rules[$field->id] = $field->validation_rules;
				}
			}
		}

		return $rules;
	}

}