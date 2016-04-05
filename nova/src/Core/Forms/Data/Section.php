<?php namespace Nova\Core\Forms\Data;

use Model, FormSectionPresenter;
use Laracasts\Presenter\PresentableTrait;

class Section extends Model {

	use PresentableTrait;

	protected $table = 'forms_sections';

	protected $fillable = ['form_id', 'tab_id', 'name', 'order', 'status',
		'message'];

	protected $dates = ['created_at', 'updated_at'];

	protected $presenter = FormSectionPresenter::class;

	//-------------------------------------------------------------------------
	// Relationships
	//-------------------------------------------------------------------------

	public function fields()
	{
		return $this->hasMany('NovaFormField')->orderBy('order');
	}

	public function form()
	{
		return $this->belongsTo('NovaForm');
	}

	public function tab()
	{
		return $this->belongsTo('NovaFormTab');
	}
	
}
