<?php namespace Nova\Authorize;

use Eloquent;
use Nova\Users\User;
use Laracasts\Presenter\PresentableTrait;

class Role extends Eloquent
{
	use PresentableTrait;

	protected $table = 'roles';
	protected $fillable = ['name'];
	protected $presenter = Presenters\RolePresenter::class;

	//--------------------------------------------------------------------------
	// Relationships
	//--------------------------------------------------------------------------

	public function permissions()
	{
		return $this->belongsToMany(Permission::class, 'permissions_roles');
	}

	public function users()
	{
		return $this->belongsToMany(User::class, 'users_roles');
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
}
