<?php namespace Nova\Core\Forms\Data;

use Model, NovaFormFieldValuePresenter;
use Laracasts\Presenter\PresentableTrait;

class FieldValue extends Model {

	use PresentableTrait;

	protected $table = 'forms_fields_values';

	protected $fillable = ['field_id', 'value', 'name', 'order', 'status'];

	protected $dates = ['created_at', 'updated_at'];

	protected $presenter = NovaFormFieldValuePresenter::class;

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public function field()
	{
		return $this->belongsTo('NovaFormField');
	}
	
}
