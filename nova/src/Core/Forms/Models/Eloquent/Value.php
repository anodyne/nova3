<?php namespace Nova\Core\Models\Eloquent\Form;

use Model;

class Value extends Model {
	
	protected $table = 'form_values';

	protected $fillable = [
		'field_id', 'value', 'order',
	];

	protected $dates = ['created_at', 'updated_at'];
	
	protected static $properties = [
		'id', 'field_id', 'value', 'order', 'created_at', 'updated_at',
	];

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
		return $this->belongsTo('FormFieldModel', 'field_id');
	}

	/**
	 * Has Many: Data
	 */
	public function data()
	{
		return $this->hasMany('FormDataModel');
	}

}