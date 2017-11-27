<?php namespace Nova\Settings\Policies;

use Nova\Users\User;
use Nova\Settings\Settings;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingsPolicy
{
	use HandlesAuthorization;

	public function view(User $user, Settings $setting)
	{
		return true;
	}

	public function create(User $user)
	{
		return $user->can('settings.create');
	}

	public function manage(User $user, Settings $setting)
	{
		return ($this->create($user)
			or $this->update($user, $position)
			or $this->delete($user, $position));
	}

	public function update(User $user, Settings $setting)
	{
		return $user->can('settings.update');
	}

	public function delete(User $user, Settings $setting)
	{
		return $user->can('settings.delete');
	}
}
