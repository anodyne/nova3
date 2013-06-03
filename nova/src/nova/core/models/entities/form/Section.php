<?php namespace Nova\Core\Models\Entities\Form;

use Event;
use Model;
use Config;

class Section extends Model {
	
	protected $table = 'form_sections';

	protected $fillable = array(
		'form_id', 'tab_id', 'name', 'order', 'status',
	);

	protected $dates = array('created_at', 'updated_at');
	
	protected static $properties = array(
		'id', 'form_id', 'tab_id', 'name', 'order', 'status', 'created_at', 
		'updated_at',
	);

	/**
	 * Belongs To: Tab
	 */
	/*public function tab()
	{
		return $this->belongsTo('NovaFormTab', 'tab_id');
	}

	/**
	 * Has Many: Fields
	 */
	/*public function fields()
	{
		return $this->hasMany('NovaFormField', 'field_id');
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
	/*public static function boot()
	{
		parent::boot();

		// Get all the aliases
		$classes = Config::get('app.aliases');

		/*Event::listen("eloquent.created: {$classes['NovaFormSection']}", "{$classes['NovaFormSectionHandler']}@afterCreate");
		Event::listen("eloquent.updated: {$classes['NovaFormSection']}", "{$classes['NovaFormSectionHandler']}@afterUpdate");
		Event::listen("eloquent.deleting: {$classes['NovaFormSection']}", "{$classes['NovaFormSectionHandler']}@beforeDelete");*/
	//}

	/**
	 * Get sections.
	 *
	 * @param	string	The form key
	 * @return	array
	 */
	/*public static function getItems($key)
	{
		// Start a new query
		$query = static::startQuery();

		$items = $query->where('form_id', $key)->orderBy('name', 'asc')->get();

		return $items->toSimpleArray();
	}*/

}