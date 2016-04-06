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

	public function fields($all = false)
	{
		if ($all)
		{
			return $this->hasMany('NovaFormField')
				->orderBy('order');
		}

		return $this->hasMany('NovaFormField')
			->active()
			->orderBy('order');
	}

	public function fieldsUnbound($all = false)
	{
		if ($all)
		{
			return $this->hasMany('NovaFormField')
				->where('tab_id', 0)
				->where('section_id', 0)
				->orderBy('order');
		}

		return $this->hasMany('NovaFormField')
			->active()
			->where('tab_id', 0)
			->where('section_id', 0)
			->orderBy('order');
	}

	public function sections($all = false)
	{
		if ($all)
		{
			return $this->hasMany('NovaFormSection')->orderBy('order');
		}

		return $this->hasMany('NovaFormSection')
			->active()
			->orderBy('order');
	}

	public function sectionsUnbound($all = false)
	{
		if ($all)
		{
			return $this->hasMany('NovaFormSection')
				->where('tab_id', 0)
				->orderBy('order');
		}

		return $this->hasMany('NovaFormSection')
			->active()
			->where('tab_id', 0)
			->orderBy('order');
	}

	public function tabs($all = false)
	{
		if ($all)
		{
			return $this->hasMany('NovaFormTab')->orderBy('order');
		}
		
		return $this->hasMany('NovaFormTab')
			->active()
			->orderBy('order');
	}

	public function parentTabs($all = false)
	{
		if ($all)
		{
			return $this->hasMany('NovaFormTab')
				->where('parent_id', '=', 0)
				->orderBy('order');
		}

		return $this->hasMany('NovaFormTab')
			->active()
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
