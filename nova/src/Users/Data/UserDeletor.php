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

		// Delete the user
		$user->delete();

		return $user;
	}
}
