<?php namespace Nova\Core\Users\Data\Models;

use Hash,
	Model;
use Illuminate\Auth\Authenticatable;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model {

	use Authenticatable, SoftDeletes;
	use PresentableTrait;

	protected $table = 'users';

	protected $fillable = ['name', 'email', 'password', 'remember_token'];

	protected $hidden = ['password', 'remember_token'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Nova\Core\Users\Data\Presenters\UserPresenter';

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/

	public function characters()
	{
		return $this->hasMany('Character');
	}

	/*
	|--------------------------------------------------------------------------
	| Getters/Setters
	|--------------------------------------------------------------------------
	*/

	/**
	 * Make sure the password is hashed.
	 *
	 * @param	string	$value	Password
	 * @return	void
	 */
	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = Hash::make($value);
	}

}
