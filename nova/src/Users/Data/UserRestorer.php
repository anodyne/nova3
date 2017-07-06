<?php namespace Nova\Users\Data;

use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Restorable;

class UserRestorer implements Restorable
{
	use BindsData;

	public function restore($user)
	{
		$user->restore();

		// $user->status = Status::ACTIVE;
		// $user->save();

		return $user;
	}
}
