<?php namespace Nova\Users\Data;

use Status;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Deletable;

class UserDeletor implements Deletable
{
	use BindsData;

	public function delete($user)
	{
		// Update the user status
		$user->update(['status' => Status::REMOVED]);

		// Detach any roles the user has
		$user->roles->each(function ($role) use ($user) {
			$user->detachRole($role);
		});

		// Delete any media the user has
		$user->media->each(function ($media) {
			deletor('Nova\Foundation\Media')->delete($media);
		});

		// Delete any characters the user has
		$user->characters->each(function ($character) {
			deletor('Nova\Characters\Character')->delete($character);
		});

		// Delete the user
		$user->delete();

		return $user;
	}
}
