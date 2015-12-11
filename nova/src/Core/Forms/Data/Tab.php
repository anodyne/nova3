<?php namespace Nova\Core\Forms\Data;

use Model, FormTabPresenter;
use Laracasts\Presenter\PresentableTrait;

class Tab extends Model {

	use PresentableTrait;

	protected $table = 'forms_tabs';

	protected $fillable = ['form_id', 'name', 'link_id', 'order', 'status',
		'parent_id'];

	protected $dates = ['created_at', 'updated_at'];

	protected $presenter = FormTabPresenter::class;

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public function fields()
	{
		return $this->sections->fields();
	}

	public function form()
	{
		return $this->belongsTo('NovaForm');
	}

	public function sections()
	{
		return $this->hasMany('NovaFormSection');
	}

	public function childrenTabs()
	{
		return $this->hasMany(self::class, 'parent_id', 'id')->orderBy('order');
	}

	public function parentTab()
	{
		return $this->belongsTo(self::class, 'parent_id', 'id');
	}
	
}
