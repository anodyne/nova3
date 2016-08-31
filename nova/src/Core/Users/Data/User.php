<?php namespace Nova\Core\Users\Data;

use Status,
	HasRoles,
	Character,
	NovaFormEntry,
	UserPresenter,
	FormCenterUserTrait;
use Illuminate\Notifications\Notifiable;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

	use SoftDeletes, Notifiable;
	use PresentableTrait, HasRoles, FormCenterUserTrait;

	protected $table = 'users';

	protected $fillable = ['name', 'nickname', 'email', 'password',
		'remember_token', 'api_token', 'status', 'last_password_reset'];

	protected $hidden = ['password', 'remember_token', 'api_token', 'created_at',
		'updated_at', 'deleted_at', 'pivot', 'last_password_reset'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at',
		'last_password_reset'];

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
	// Model Methods
	//-------------------------------------------------------------------------

	public function activate()
	{
		$this->status = Status::ACTIVE;
		$this->save();

		return $this;
	}

	public function canBeDeleted()
	{
		if ($this->characters->count() > 0) return false;

		return true;
	}

	public function deactivate()
	{
		$this->status = Status::INACTIVE;
		$this->save();

		return $this;
	}

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
