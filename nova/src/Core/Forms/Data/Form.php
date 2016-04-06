<?php namespace Nova\Core\Forms\Data;

use Model,
	Status,
	StatusTrait,
	FormPresenter;
use Laracasts\Presenter\PresentableTrait;

class Form extends Model {

	use StatusTrait, PresentableTrait;

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
		return $this->hasMany('NovaFormField')
			->active()
			->orderBy('order');
	}

	public function fieldsAll()
	{
		return $this->hasMany('NovaFormField')
			->orderBy('order');
	}

	public function fieldsUnbound()
	{
		return $this->hasMany('NovaFormField')
			->active()
			->where('tab_id', 0)
			->where('section_id', 0)
			->orderBy('order');
	}

	public function fieldsUnboundAll()
	{
		return $this->hasMany('NovaFormField')
			->where('tab_id', 0)
			->where('section_id', 0)
			->orderBy('order');
	}

	public function sections()
	{
		return $this->hasMany('NovaFormSection')
			->active()
			->orderBy('order');
	}

	public function sectionsAll()
	{
		return $this->hasMany('NovaFormSection')
			->orderBy('order');
	}

	public function sectionsUnbound()
	{
		return $this->hasMany('NovaFormSection')
			->active()
			->where('tab_id', 0)
			->orderBy('order');
	}

	public function sectionsUnboundAll()
	{
		return $this->hasMany('NovaFormSection')
			->where('tab_id', 0)
			->orderBy('order');
	}

	public function tabs()
	{
		return $this->hasMany('NovaFormTab')
			->active()
			->orderBy('order');
	}

	public function tabsAll()
	{
		return $this->hasMany('NovaFormTab')
			->orderBy('order');
	}

	public function parentTabs()
	{
		return $this->hasMany('NovaFormTab')
			->active()
			->where('parent_id', '=', 0)
			->orderBy('order');
	}

	public function parentTabsAll()
	{
		return $this->hasMany('NovaFormTab')
			->where('parent_id', '=', 0)
			->orderBy('order');
	}

	//-------------------------------------------------------------------------
	// Scopes
	//-------------------------------------------------------------------------

	public function scopeFormCenter($query)
	{
		$query->where('form_center', (int) true);
	}
	
}
