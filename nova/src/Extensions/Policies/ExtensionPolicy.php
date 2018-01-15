<?php namespace Nova\Extensions\Policies;

use Nova\Users\User;
use Nova\Extensions\SystemExtension;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExtensionPolicy
{
	use HandlesAuthorization;

	public function view(User $user, SystemExtension $extension)
	{
		return true;
	}

	public function create(User $user)
	{
		return $user->can('extension.create');
	}

	public function manage(User $user, SystemExtension $extension)
	{
		return ($this->create($user)
			or $this->update($user, $extension)
			or $this->delete($user, $extension));
	}

	public function update(User $user, SystemExtension $extension)
	{
		return $user->can('extension.update');
	}

	public function delete(User $user, SystemExtension $extension)
	{
		return $user->can('extension.delete');
	}
}
