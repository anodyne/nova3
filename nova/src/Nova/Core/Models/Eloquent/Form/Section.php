<?php namespace Nova\Core\Models\Eloquent\Form;

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

		// Setup the listeners
		static::setupEventListeners($a['NovaFormSection'], $a['FormSectionModelEventHandler']);
	}

}