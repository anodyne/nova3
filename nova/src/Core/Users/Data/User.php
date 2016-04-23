<?php namespace Nova\Core\Users\Data;

use Hash,
	Model,
	HasRoles,
	Character,
	NovaFormEntry,
	UserPresenter,
	FormCenterUserTrait;
use Illuminate\Auth\Authenticatable,
	Illuminate\Auth\Passwords\CanResetPassword,
	Illuminate\Foundation\Auth\Access\Authorizable;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract,
	Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract,
	Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract, AuthorizableContract {

	use Authenticatable, CanResetPassword, SoftDeletes, Authorizable;
	use PresentableTrait, HasRoles, FormCenterUserTrait;

	protected $table = 'users';

	protected $fillable = ['name', 'nickname', 'email', 'password',
		'remember_token', 'api_token', 'status'];

	protected $hidden = ['password', 'remember_token', 'api_token'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $presenter = UserPresenter::class;

	//-------------------------------------------------------------------------
	// Relationships
	//-------------------------------------------------------------------------

	public function characters()
	{
		return $this->hasMany(Character::class);
	}

	public function formCenterEntries()
	{
		return $this->hasMany(NovaFormEntry::class);
	}

	public function userPreferences()
	{
		return $this->hasMany(UserPreference::class);
	}

	//-------------------------------------------------------------------------
	// Getters/Setters
	//-------------------------------------------------------------------------

	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = Hash::make($value);
	}

	//-------------------------------------------------------------------------
	// Model Methods
	//-------------------------------------------------------------------------

	public function preference($key)
	{
		$item = $this->userPreferences->where('key', $key);

		if ($item->count() > 0)
		{
			return $item->first()->value;
		}

		return null;
	}

}
