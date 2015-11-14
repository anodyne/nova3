<?php namespace Nova\Core\Forms\Data;

use Model, NovaFormDataPresenter;
use Laracasts\Presenter\PresentableTrait;

class Data extends Model {

	use PresentableTrait;

	protected $table = 'forms_data';

	protected $fillable = ['form_id', 'field_id', 'data_id', 'value',
		'created_by'];

	protected $dates = ['created_at', 'updated_at'];

	protected $presenter = NovaFormDataPresenter::class;

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public function form()
	{
		return $this->belongsTo('NovaForm');
	}

	public function field()
	{
		return $this->belongsTo('NovaFormField');
	}
	
}
