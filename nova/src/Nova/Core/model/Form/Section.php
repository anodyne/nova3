<?php namespace Nova\Core\Model\Form;

use Event;
use Model;
use Config;

class Section extends Model {
	
	protected $table = 'form_sections';

	protected $fillable = array(
		'form_key', 'tab_id', 'name', 'order', 'status',
	);
	
	protected static $properties = array(
		'id', 'form_key', 'tab_id', 'name', 'order', 'status', 'created_at', 
		'updated_at',
	);

	/**
	 * Belongs To: Tab
	 */
	public function tab()
	{
		return $this->belongsTo('NovaFormTab');
	}

	/**
	 * Has Many: Fields
	 */
	public function fields()
	{
		return $this->hasMany('NovaFormField');
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

		Event::listen("eloquent.created: {$classes['NovaFormSection']}", "{$classes['NovaFormSectionHandler']}@afterCreate");
		Event::listen("eloquent.updated: {$classes['NovaFormSection']}", "{$classes['NovaFormSectionHandler']}@afterUpdate");
		Event::listen("eloquent.deleting: {$classes['NovaFormSection']}", "{$classes['NovaFormSectionHandler']}@beforeDelete");
	}

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