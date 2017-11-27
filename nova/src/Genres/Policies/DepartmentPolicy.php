<?php namespace Nova\Genres\Policies;

use Nova\Users\User;
use Nova\Genres\Department;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy
{
	use HandlesAuthorization;

	public function view(User $user, Department $department)
	{
		return true;
	}

	public function create(User $user)
	{
		return $user->can('dept.create');
	}

	public function manage(User $user, Department $department)
	{
		return ($this->create($user)
			or $this->update($user, $department)
			or $this->delete($user, $department));
	}

	public function update(User $user, Department $department)
	{
		return $user->can('dept.update');
	}

	public function delete(User $user, Department $department)
	{
		return $user->can('dept.delete');
	}
}
