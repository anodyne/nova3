<?php namespace Nova\Core\Models\Entities\Form;

use Event;
use Model;
use Config;
use FormTrait;

class Section extends Model {

	use FormTrait;
	
	protected $table = 'form_sections';

	protected $fillable = array(
		'form_id', 'tab_id', 'name', 'order', 'status',
	);

	protected $dates = array('created_at', 'updated_at');
	
	protected static $properties = array(
		'id', 'form_id', 'tab_id', 'name', 'order', 'status', 'created_at', 
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
	 * Belongs To: Tab
	 */
	public function tab()
	{
		return $this->belongsTo('NovaFormTab', 'tab_id');
	}

	/**
	 * Has Many: Fields
	 */
	public function fields()
	{
		return $this->hasMany('NovaFormField')->orderAsc('order');
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

		Event::listen("eloquent.creating: {$a['NovaFormSection']}", "{$a['FormSectionEventHandler']}@beforeCreate");
		Event::listen("eloquent.created: {$a['NovaFormSection']}", "{$a['FormSectionEventHandler']}@afterCreate");
		Event::listen("eloquent.updating: {$a['NovaFormSection']}", "{$a['FormSectionEventHandler']}@beforeUpdate");
		Event::listen("eloquent.updated: {$a['NovaFormSection']}", "{$a['FormSectionEventHandler']}@afterUpdate");
		Event::listen("eloquent.deleting: {$a['NovaFormSection']}", "{$a['FormSectionEventHandler']}@beforeDelete");
		Event::listen("eloquent.deleted: {$a['NovaFormSection']}", "{$a['FormSectionEventHandler']}@afterDelete");
		Event::listen("eloquent.saving: {$a['NovaFormSection']}", "{$a['FormSectionEventHandler']}@beforeSave");
		Event::listen("eloquent.saved: {$a['NovaFormSection']}", "{$a['FormSectionEventHandler']}@afterSave");
	}

}