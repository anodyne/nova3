<?php namespace Nova\Core\Model\Form;

use Event;
use Model;
use Config;

class Tab extends Model {
	
	protected $table = 'form_tabs';

	protected $fillable = array(
		'form_key', 'name', 'link_id', 'order', 'status',
	);
	
	protected static $properties = array(
		'id', 'form_key', 'name', 'link_id', 'order', 'status', 'created_at', 
		'updated_at',
	);

	/**
	 * Has Many: Sections
	 */
	public function sections()
	{
		return $this->hasMany('NovaFormSection');
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

		Event::listen("eloquent.created: {$classes['NovaFormTab']}", "{$classes['NovaFormTabHandler']}@afterCreate");
		Event::listen("eloquent.updated: {$classes['NovaFormTab']}", "{$classes['NovaFormTabHandler']}@afterUpdate");
		Event::listen("eloquent.deleting: {$classes['NovaFormTab']}", "{$classes['NovaFormTabHandler']}@beforeDelete");
	}

	/**
	 * Get tabs.
	 *
	 * @param	string	The form key
	 * @return	array
	 */
	public static function getItems($key)
	{
		// Start a new query
		$query = static::startQuery();

		// Get the items
		$items = $query->where('form_key', $key)->orderBy('name', 'asc')->get();

		return $items->toSimpleArray();
	}

}