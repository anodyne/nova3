<?php namespace Nova\Core\Models\Eloquent\Form;

use Model;
use FormTrait;

class Section extends Model {

	use FormTrait;
	
	protected $table = 'form_sections';

	protected $fillable = [
		'form_id', 'tab_id', 'name', 'order', 'status',
	];

	protected $dates = ['created_at', 'updated_at'];
	
	protected static $properties = [
		'id', 'form_id', 'tab_id', 'name', 'order', 'status', 'created_at', 
		'updated_at',
	];

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
		return $this->belongsTo('FormModel', 'form_id');
	}

	/**
	 * Belongs To: Tab
	 */
	public function tab()
	{
		return $this->belongsTo('FormTabModel', 'tab_id');
	}

	/**
	 * Has Many: Fields
	 */
	public function fields()
	{
		return $this->hasMany('FormFieldModel')->orderAsc('order');
	}

}