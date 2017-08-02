<?php namespace Nova\Characters\Policies;

use Nova\Users\User;
use Nova\Characters\Character;
use Illuminate\Auth\Access\HandlesAuthorization;

class CharacterPolicy
{
	use HandlesAuthorization;

	public function view(User $user, Character $character)
	{
		return true;
	}

	public function create(User $user)
	{
		return $user->can('character.create');
	}

	public function manage(User $user, Character $character)
	{
		return ($this->create($user)
			or $this->update($user, $character)
			or $this->delete($user, $character));
	}

	public function update(User $user, Character $character)
	{
		return $user->can('character.update');
	}

	public function updateBio(User $user, Character $character)
	{
		return (int) $user->id === (int) $character->user->id;
	}

	public function delete(User $user, Character $character)
	{
		return $user->can('character.delete');
	}
}
