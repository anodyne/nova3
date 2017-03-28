<?php namespace Nova\Core\Forms\Data;

use Model;
use FormDataPresenter;
use Laracasts\Presenter\PresentableTrait;

class Data extends Model
{
	use PresentableTrait;

	protected $table = 'forms_data';

	protected $fillable = ['form_id', 'field_id', 'entry_id', 'value', 'user_id'];

	protected $dates = ['created_at', 'updated_at'];

	protected $touches = ['entry'];

	protected $presenter = FormDataPresenter::class;

	//-------------------------------------------------------------------------
	// Relationships
	//-------------------------------------------------------------------------

	public function entry()
	{
		return $this->belongsTo('NovaFormEntry');
	}

	public function form()
	{
		return $this->belongsTo('NovaForm');
	}

	public function field()
	{
		return $this->belongsTo('NovaFormField');
	}

	public function user()
	{
		return $this->belongsTo('User');
	}
}
