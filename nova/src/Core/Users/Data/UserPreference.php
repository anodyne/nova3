<?php namespace Nova\Core\Users\Data;

use Model;

class UserPreference extends Model
{
	public $timestamps = false;

	protected $table = 'users_preferences';

	protected $fillable = ['user_id', 'key', 'value'];

	//-------------------------------------------------------------------------
	// Relationships
	//-------------------------------------------------------------------------

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
