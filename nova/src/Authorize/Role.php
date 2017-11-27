<?php namespace Nova\Authorize;

use Eloquent;
use Laracasts\Presenter\PresentableTrait;

class Role extends Eloquent
{
	use PresentableTrait;

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
}
