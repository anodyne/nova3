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
		'use_form_center', 'message', 'email_recipients', 'resource_creating',
		'resource_editing', 'allow_multiple_submissions', 'allow_entry_editing',
		'allow_entry_removal'];

	protected $dates = ['created_at', 'updated_at'];

	protected $presenter = FormPresenter::class;

	protected $casts = [
		'protected' => 'boolean',
		'use_form_center' => 'boolean',
		'allow_multiple_submissions' => 'boolean',
		'allow_entry_editing' => 'boolean',
		'allow_entry_removal' => 'boolean',
	];

	//-------------------------------------------------------------------------
	// Relationships
	//-------------------------------------------------------------------------

	public function data()
	{
		return $this->hasMany('NovaFormData');
	}

	public function entries()
	{
		return $this->hasMany('NovaFormEntry');
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
		$query->where('use_form_center', (int) true);
	}
	
}
