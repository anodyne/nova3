<?php namespace Nova\Core\Models\Eloquent\Form;

use Model;
use FormTrait;

class Tab extends Model {

	use FormTrait;
	
	protected $table = 'form_tabs';

	protected $fillable = [
		'form_id', 'name', 'link_id', 'order', 'status',
	];

	protected $dates = ['created_at', 'updated_at'];
	
	protected static $properties = [
		'id', 'form_id', 'name', 'link_id', 'order', 'status', 'created_at', 
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
	 * Has Many: Sections
	 */
	public function sections()
	{
		return $this->hasMany('FormSectionModel')->orderAsc('order');
	}

	/**
	 * Has Many: Fields
	 */
	public function fields()
	{
		return $this->hasMany('FormFieldModel')->orderAsc('order');
	}

}