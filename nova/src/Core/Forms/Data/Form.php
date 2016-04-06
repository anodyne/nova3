<?php namespace Nova\Core\Forms\Data;

use Model, FormPresenter;
use Laracasts\Presenter\PresentableTrait;

class Form extends Model {

	use PresentableTrait;

	protected $table = 'forms';

	protected $fillable = ['key', 'name', 'orientation', 'status', 'protected',
		'form_center', 'form_center_message', 'form_center_display',
		'email_allowed', 'email_address', 'resource_creating', 'resource_editing'];

	protected $dates = ['created_at', 'updated_at'];

	protected $presenter = FormPresenter::class;

	protected $casts = [
		'protected'		=> 'boolean',
		'form_center'	=> 'boolean',
		'email_allowed'	=> 'boolean',
	];

	//-------------------------------------------------------------------------
	// Relationships
	//-------------------------------------------------------------------------

	public function data()
	{
		return $this->hasMany('NovaFormData');
	}

	public function fields()
	{
		return $this->hasMany('NovaFormField');
	}

	public function fieldsUnbound()
	{
		return $this->hasMany('NovaFormField')
			->where('tab_id', 0)
			->where('section_id', 0)
			->orderBy('order');
	}

	public function sections()
	{
		return $this->hasMany('NovaFormSection')->orderBy('order');
	}

	public function sectionsUnbound()
	{
		return $this->hasMany('NovaFormSection')
			->where('tab_id', 0)
			->orderBy('order');
	}

	public function tabs()
	{
		return $this->hasMany('NovaFormTab')->orderBy('order');
	}

	public function parentTabs()
	{
		return $this->hasMany('NovaFormTab')
			->where('parent_id', '=', 0)
			->orderBy('order');
	}
	
}
