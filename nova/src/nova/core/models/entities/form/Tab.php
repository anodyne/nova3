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
		$a = Config::get('app.aliases');

		Event::listen("eloquent.creating: {$a['NovaFormTab']}", "{$a['FormTabEventHandler']}@beforeCreate");
		Event::listen("eloquent.created: {$a['NovaFormTab']}", "{$a['FormTabEventHandler']}@afterCreate");
		Event::listen("eloquent.updating: {$a['NovaFormTab']}", "{$a['FormTabEventHandler']}@beforeUpdate");
		Event::listen("eloquent.updated: {$a['NovaFormTab']}", "{$a['FormTabEventHandler']}@afterUpdate");
		Event::listen("eloquent.deleting: {$a['NovaFormTab']}", "{$a['FormTabEventHandler']}@beforeDelete");
		Event::listen("eloquent.deleted: {$a['NovaFormTab']}", "{$a['FormTabEventHandler']}@afterDelete");
		Event::listen("eloquent.saving: {$a['NovaFormTab']}", "{$a['FormTabEventHandler']}@beforeSave");
		Event::listen("eloquent.saved: {$a['NovaFormTab']}", "{$a['FormTabEventHandler']}@afterSave");
	}

}