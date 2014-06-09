<?php namespace Nova\Core\Models\Eloquent;

use Model;

class UserPersistenceModel extends Model {

	public $timestamps = false;

	protected $table = 'users_persistence';

	protected $fillable = ['user_id', 'code'];

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/

	public function user()
	{
		return $this->belongsTo('UserModel');
	}

}