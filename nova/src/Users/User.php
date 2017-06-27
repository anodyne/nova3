<?php namespace Nova\Users;

use Mail;
use Nova\Authorize\Role;
use Nova\Auth\Mail\SendPasswordReset;
use Illuminate\Notifications\Notifiable;
use Laracasts\Presenter\PresentableTrait;
use Nova\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use Notifiable, SoftDeletes, PresentableTrait;

	protected $table = 'users';
	protected $fillable = ['name', 'email', 'password', 'nickname'];
	protected $hidden = ['password', 'remember_token'];
	protected $presenter = Presenters\UserPresenter::class;

	//--------------------------------------------------------------------------
	// Relationships
	//--------------------------------------------------------------------------

	public function roles()
	{
		return $this->belongsToMany(Role::class, 'users_roles', 'user_id', 'role_id');
	}

	//--------------------------------------------------------------------------
	// Model Methods
	//--------------------------------------------------------------------------

	public static function create(array $attributes = [], array $options = [])
	{
		$user = (new static)->newQuery()->create($attributes);

		if (array_key_exists('roles', $attributes)) {
			$user->roles()->sync($attributes['roles']);
		}

		return $user;
	}

	public function sendPasswordResetNotification($token)
	{
		Mail::to($this->email)->send(new SendPasswordReset($token));
	}

	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = bcrypt($value);
	}
}
