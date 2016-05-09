<?php namespace Nova\Core\Characters\Data;

use User, Model;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Character extends Model {

	use SoftDeletes, PresentableTrait;

	protected $table = 'characters';

	protected $fillable = ['user_id', 'first_name', 'middle_name', 'last_name'];

	protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Nova\Core\Characters\Data\Presenters\CharacterPresenter';

	//-------------------------------------------------------------------------
	// Relationships
	//-------------------------------------------------------------------------

	public function user()
	{
		return $this->belongsTo(User::class);
	}
	
}
