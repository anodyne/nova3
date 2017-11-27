<?php namespace Nova\Genres\Policies;

use Nova\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RankPolicy
{
	use HandlesAuthorization;

	public function view(User $user, $model)
	{
		return true;
	}

	public function create(User $user)
	{
		return $user->can('rank.create');
	}

	public function manage(User $user, $model)
	{
		return ($this->create($user)
			or $this->update($user, $model)
			or $this->delete($user, $model));
	}

	public function update(User $user, $model)
	{
		return $user->can('rank.update');
	}

	public function delete(User $user, $model)
	{
		return $user->can('rank.delete');
	}
}
