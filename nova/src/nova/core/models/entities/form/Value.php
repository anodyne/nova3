<?php namespace Nova\Core\Models\Entities\Form;

use Event;
use Model;
use Config;

class Value extends Model {
	
	protected $table = 'form_values';

	protected $fillable = array(
		'field_id', 'value', 'order',
	);

	protected $dates = array('created_at', 'updated_at');
	
	protected static $properties = array(
		'id', 'field_id', 'value', 'order', 'created_at', 'updated_at',
	);

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/

	/**
	 * Belongs To: Field
	 */
	public function field()
	{
		return $this->belongsTo('NovaFormField', 'field_id');
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

		Event::listen("eloquent.creating: {$a['NovaFormValue']}", "{$a['FormValueEventHandler']}@beforeCreate");
		Event::listen("eloquent.created: {$a['NovaFormValue']}", "{$a['FormValueEventHandler']}@afterCreate");
		Event::listen("eloquent.updating: {$a['NovaFormValue']}", "{$a['FormValueEventHandler']}@beforeUpdate");
		Event::listen("eloquent.updated: {$a['NovaFormValue']}", "{$a['FormValueEventHandler']}@afterUpdate");
		Event::listen("eloquent.deleting: {$a['NovaFormValue']}", "{$a['FormValueEventHandler']}@beforeDelete");
		Event::listen("eloquent.deleted: {$a['NovaFormValue']}", "{$a['FormValueEventHandler']}@afterDelete");
		Event::listen("eloquent.saving: {$a['NovaFormValue']}", "{$a['FormValueEventHandler']}@beforeSave");
		Event::listen("eloquent.saved: {$a['NovaFormValue']}", "{$a['FormValueEventHandler']}@afterSave");
	}

}