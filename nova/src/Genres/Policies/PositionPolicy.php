<?php namespace Nova\Genres\Policies;

use Nova\Users\User;
use Nova\Genres\Position;
use Illuminate\Auth\Access\HandlesAuthorization;

class PositionPolicy
{
	use HandlesAuthorization;

	public function view(User $user, Position $position)
	{
		return true;
	}

	public function create(User $user)
	{
		return $user->can('position.create');
	}

	public function manage(User $user, Position $position)
	{
		return ($this->create($user)
			or $this->update($user, $position)
			or $this->delete($user, $position));
	}

	public function update(User $user, Position $position)
	{
		return $user->can('position.update');
	}

	public function delete(User $user, Position $position)
	{
		return $user->can('position.delete');
	}
}
