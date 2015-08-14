<?php namespace Nova\Core\Forms\Data;

use Model, NovaFormFieldPresenter;
use Laracasts\Presenter\PresentableTrait;

class Field extends Model {

	use PresentableTrait;

	protected $table = 'forms_fields';

	protected $fillable = ['form_id', 'tab_id', 'section_id', 'type', 'label',
		'order', 'status', 'restriction', 'help', 'selected', 'value',
		'html_id', 'html_class', 'html_rows', 'html_container_class',
		'placeholder', 'validation_rules'];

	protected $dates = ['created_at', 'updated_at'];

	protected $presenter = NovaFormFieldPresenter::class;

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
