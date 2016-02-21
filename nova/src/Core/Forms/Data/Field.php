<?php namespace Nova\Core\Forms\Data;

use Model, FormFieldPresenter;
use Laracasts\Presenter\PresentableTrait;

class Field extends Model {

	use PresentableTrait;

	protected $table = 'forms_fields';

	protected $fillable = ['form_id', 'tab_id', 'section_id', 'type', 'label',
		'order', 'status', 'restriction', 'help', 'selected', 'value',
		'attribute_id', 'attribute_class', 'attribute_rows', 'field_container_class',
		'attribute_placeholder', 'validation_rules', 'label_container_class'];

	protected $dates = ['created_at', 'updated_at'];

	protected $presenter = FormFieldPresenter::class;

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public function form()
	{
		return $this->belongsTo('NovaForm');
	}

	public function section()
	{
		return $this->belongsTo('NovaFormSection');
	}

	public function tab()
	{
		return $this->belongsTo('NovaFormTab');
	}

	public function values()
	{
		return $this->hasMany('NovaFormFieldValue');
	}
	
}
