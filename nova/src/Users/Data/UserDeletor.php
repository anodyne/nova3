<?php namespace Nova\Users\Data;

use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Deletable;

class UserDeletor implements Deletable
{
	use BindsData;

	public function delete($user)
	{
		// Delete the user
		$user->delete();

		return $user;
	}
}
