<?php namespace Nova\Core\Forms\Data;

use User;
use Model;
use FormEntryPresenter;
use Laracasts\Presenter\PresentableTrait;

class Entry extends Model
{
	use PresentableTrait;

	protected $table = 'forms_entries';

	protected $fillable = ['form_id', 'user_id'];

	protected $dates = ['created_at', 'updated_at'];

	protected $presenter = FormEntryPresenter::class;

	//-------------------------------------------------------------------------
	// Relationships
	//-------------------------------------------------------------------------

	public function form()
	{
		return $this->belongsTo('NovaForm');
	}

	public function data()
	{
		return $this->hasMany('NovaFormData');
	}

	public function user()
	{
		return $this->belongsTo('User');
	}
}
