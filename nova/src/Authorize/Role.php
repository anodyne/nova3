<?php namespace Nova\Authorize;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Role extends Model
{
	use LogsActivity, PresentableTrait;

	protected $fillable = ['name'];
	protected $presenter = Presenters\RolePresenter::class;
	protected $table = 'roles';

	//--------------------------------------------------------------------------
	// Relationships
	//--------------------------------------------------------------------------

	public function permissions()
	{
		return $this->belongsToMany(Permission::class, 'permissions_roles');
	}

	public function users()
	{
		return $this->belongsToMany('Nova\Users\User', 'users_roles');
	}

	//--------------------------------------------------------------------------
	// Model Methods
	//--------------------------------------------------------------------------

	public function scopeName($query, $roleName)
	{
		return $query->where('name', $roleName);
	}

	public function updatePermissions(array $data)
	{
		$this->permissions()->sync($data);

		return $this;
	}

	public function removePermissions()
	{
		$this->updatePermissions([]);

		return $this;
	}

	//--------------------------------------------------------------------------
	// Activity Logging
	//--------------------------------------------------------------------------

	protected static $logAttributes = ['name'];

	public function getDescriptionForEvent(string $eventName): string
	{
		return "Role :subject.name was {$eventName}";
	}

	public function getLogNameToUse(string $eventName = ''): string
	{
		return 'nova-authorize';
	}
}
