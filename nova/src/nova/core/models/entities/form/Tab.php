<?php namespace Nova\Core\Models\Entities\Form;

use Event;
use Model;
use Config;

class Tab extends Model {
	
	protected $table = 'form_tabs';

	protected $fillable = array(
		'form_id', 'name', 'link_id', 'order', 'status',
	);

	protected $dates = array('created_at', 'updated_at');
	
	protected static $properties = array(
		'id', 'form_id', 'name', 'link_id', 'order', 'status', 'created_at', 
		'updated_at',
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

		// Create event
		Event::listen(
			"eloquent.creating: {$classes['NovaFormTab']}",
			"{$classes['FormTabEventHandler']}@beforeCreate"
		);
		Event::listen(
			"eloquent.created: {$classes['NovaFormTab']}",
			"{$classes['FormTabEventHandler']}@afterCreate"
		);

		// Update Event
		Event::listen(
			"eloquent.updating: {$classes['NovaFormTab']}",
			"{$classes['FormTabEventHandler']}@beforeUpdate"
		);
		Event::listen(
			"eloquent.updated: {$classes['NovaFormTab']}",
			"{$classes['FormTabEventHandler']}@afterUpdate"
		);

		// Delete events
		Event::listen(
			"eloquent.deleting: {$classes['NovaFormTab']}",
			"{$classes['FormTabEventHandler']}@beforeDelete"
		);
		Event::listen(
			"eloquent.deleted: {$classes['NovaFormTab']}",
			"{$classes['FormTabEventHandler']}@afterDelete"
		);

		// Save events
		Event::listen(
			"eloquent.saving: {$classes['NovaFormTab']}",
			"{$classes['FormTabEventHandler']}@beforeSave"
		);
		Event::listen(
			"eloquent.saved: {$classes['NovaFormTab']}",
			"{$classes['FormTabEventHandler']}@afterSave"
		);
	}

}