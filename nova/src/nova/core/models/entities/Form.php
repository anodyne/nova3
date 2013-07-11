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
		'email_addresses', 'data_model',
	);

	protected $dates = array('created_at', 'updated_at');
	
	protected static $properties = array(
		'id', 'key', 'name', 'orientation', 'status', 'protected', 'form_viewer',
		'email_allowed', 'email_addresses', 'data_model', 'created_at', 'updated_at',
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

		Event::listen("eloquent.creating: {$a['NovaForm']}", "{$a['FormEventHandler']}@beforeCreate");
		Event::listen("eloquent.created: {$a['NovaForm']}", "{$a['FormEventHandler']}@afterCreate");
		Event::listen("eloquent.updating: {$a['NovaForm']}", "{$a['FormEventHandler']}@beforeUpdate");
		Event::listen("eloquent.updated: {$a['NovaForm']}", "{$a['FormEventHandler']}@afterUpdate");
		Event::listen("eloquent.deleting: {$a['NovaForm']}", "{$a['FormEventHandler']}@beforeDelete");
		Event::listen("eloquent.deleted: {$a['NovaForm']}", "{$a['FormEventHandler']}@afterDelete");
		Event::listen("eloquent.saving: {$a['NovaForm']}", "{$a['FormEventHandler']}@beforeSave");
		Event::listen("eloquent.saved: {$a['NovaForm']}", "{$a['FormEventHandler']}@afterSave");
	}

	/**
	 * Get a form by key.
	 *
	 * @param	string	The form key
	 * @return	Form
	 */
	public static function getForm($key)
	{
		// Start a new Query Builder
		$query = static::startQuery();

		return $query->where('key', $key)->first();
	}

	/**
	 * Get all forms.
	 *
	 * @param	int		The status to pull
	 * @param	bool	Get the full object (true) or a simple array (false)
	 * @return	Collection|array
	 */
	public static function getForms($status = Status::ACTIVE, $returnObj = false)
	{
		// Start a new query builder
		$query = static::startQuery();

		if ( ! empty($status))
		{
			$query->where('status', $status);
		}

		// Get everything
		$items = $query->get();

		if ($returnObj)
		{
			return $items;
		}

		return $items->toSimpleArray('key', 'name');
	}

}