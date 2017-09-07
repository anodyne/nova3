<?php namespace Nova\Users;

use Date;
use Hash;
use Mail;
use Status;
use Nova\Authorize\Role;
use Nova\Media\Data\HasMedia;
use Nova\Characters\Character;
use Nova\Foundation\Data\HasStatus;
use Nova\Auth\Mail\SendPasswordReset;
use Illuminate\Notifications\Notifiable;
use Laracasts\Presenter\PresentableTrait;
use Nova\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use Notifiable, SoftDeletes, PresentableTrait, HasStatus, HasMedia;

	protected $appends = ['avatarImage', 'displayName'];
	protected $dates = ['created_at', 'updated_at', 'deleted_at', 'last_sign_in'];
	protected $fillable = [
		'name', 'email', 'password', 'nickname', 'status', 'last_sign_in',
		'remember_token', 'primary_character', 'gender',
	];
	protected $hidden = ['password', 'remember_token'];
	protected $presenter = Presenters\UserPresenter::class;
	protected $table = 'users';
	protected $with = ['media'];

	//--------------------------------------------------------------------------
	// Relationships
	//--------------------------------------------------------------------------

	public function allCharacters()
	{
		return $this->hasMany(Character::class)->withTrashed();
	}

	public function characters()
	{
		return $this->hasMany(Character::class);
	}

	public function primaryCharacter()
	{
		return $this->hasOne(Character::class, 'id', 'primary_character');
	}

	public function roles()
	{
		return $this->belongsToMany(Role::class, 'users_roles', 'user_id', 'role_id');
	}

	//--------------------------------------------------------------------------
	// Model Methods
	//--------------------------------------------------------------------------

	public function attachRole($role)
	{
		if (is_object($role)) {
			$role = $role->getKey();
		}

		if (is_array($role)) {
			$role = $role['id'];
		}

		$this->roles()->attach($role);
	}

	public function detachRole($role)
	{
		if (is_object($role)) {
			$role = $role->getKey();
		}

		if (is_array($role)) {
			$role = $role['id'];
		}

		$this->roles()->detach($role);
	}

	public function getAvatarImageAttribute()
	{
		return $this->present()->avatarImage;
	}

	public function getDisplayNameAttribute()
	{
		return $this->present()->name;
	}

	public function getPassword()
	{
		return $this->attributes['password'];
	}

	public function hasRole($role)
	{
		if (is_string($role)) {
			return $this->roles->contains('name', $role);
		}

		return !! $role->intersect($this->roles)->count();
	}

	public function recordSignIn()
	{
		$this->last_sign_in = Date::now();
		$this->save();
	}

	public function sendPasswordResetNotification($token)
	{
		Mail::to($this->email)->send(new SendPasswordReset($token));
	}

	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = ($value !== null) ? Hash::make($value) : null;
	}

	public function setPrimaryCharacter()
	{
		$activeCharacters = $this->characters->filter(function ($character) {
			return $character->isActive();
		});

		if ($activeCharacters->count() > 0) {
			$this->setPrimaryCharacterAs($activeCharacters->first());
		} else {
			$this->attributes['primary_character'] = null;
			$this->save();
		}
	}

	public function setPrimaryCharacterAs(Character $character)
	{
		updater(self::class)->with(['primary_character' => $character->id])->update($this);

		return $this;
	}
}
