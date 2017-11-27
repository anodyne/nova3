<?php namespace Nova\Users\Data;

use Status;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Updatable;

class UserUpdater implements Updatable
{
	use BindsData;

	public function activate($user)
	{
		// Update the user status
		$user->update(['status' => Status::ACTIVE]);

		return $user->fresh();
	}

	public function deactivate($user)
	{
		// Update the user status
		$user->update(['status' => Status::INACTIVE]);

		// Deactivate all characters associated with the user
		$user->characters->each(function ($character) {
			updater('Nova\Characters\Character')->deactivate($character);
		});

		return $user->fresh();
	}

	public function update($user)
	{
		$user->update($this->data);

		return $user->fresh();
	}
}
