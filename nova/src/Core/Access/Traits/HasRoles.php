<?php namespace Nova\Core\Access\Traits;

use Role;

trait HasRoles
{
	//-------------------------------------------------------------------------
	// Relationships
	//-------------------------------------------------------------------------

	public function roles()
	{
		return $this->belongsToMany(Role::class, 'users_roles');
	}

	//-------------------------------------------------------------------------
	// Model Methods
	//-------------------------------------------------------------------------

	public function assignRole($role)
	{
		// Get the role repository
		$repo = app('RoleRepository');

		$roleObj = (is_string($role))
			? $repo->getFirstBy('key', $role)
			: $repo->find($role);
		
		return $this->roles()->save($roleObj);
	}

	public function hasRole($role)
	{
		if (is_string($role)) {
			return $this->roles->contains('key', $role);
		}

		return !! $role->intersect($this->roles)->count();
	}
}
