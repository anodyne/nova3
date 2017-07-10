<?php namespace Nova\Users\Data;

use Status;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Restorable;

class UserRestorer implements Restorable
{
	use BindsData;

	public function restore($user)
	{
		// Restore the user
		$user->restore();

		// Update their status
		$user->fresh()->update(['status' => Status::ACTIVE]);

		return $user->fresh();
	}
}
