<?php namespace Nova\Core\Forms\Data;

use Model, FormPresenter;
use Laracasts\Presenter\PresentableTrait;

class Form extends Model {

	use PresentableTrait;

	protected $table = 'forms';

	protected $fillable = ['key', 'name', 'orientation', 'status', 'protected',
		'form_viewer', 'form_viewer_message', 'form_viewer_display',
		'email_allowed', 'email_address', 'data_model'];

	protected $dates = ['created_at', 'updated_at'];

	protected $presenter = FormPresenter::class;

	//-------------------------------------------------------------------------
	// Relationships
	//-------------------------------------------------------------------------

	public function fields()
	{
		return $this->hasMany('NovaFormField');
	}

	public function sections()
	{
		return $this->hasMany('NovaFormSection');
	}

	public function tabs()
	{
		return $this->hasMany('NovaFormTab');
	}
	
}
