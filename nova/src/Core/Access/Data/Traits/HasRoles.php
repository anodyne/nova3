<?php namespace Nova\Core\Access\Data\Traits;

use Role;

trait HasRoles {

	public function roles()
	{
		return $this->belongsToMany(Role::class, 'users_roles');
	}

	public function assignRole($role)
	{
		$roleObj = (is_string($role)) ? Role::whereName($role)->firstOrFail() : Role::find($role);
		
		return $this->roles()->save($roleObj);
	}

	public function hasRole($role)
	{
		if (is_string($role))
		{
			return $this->roles->contains('name', $role);
		}

		return !! $role->intersect($this->roles)->count();
	}
}
