<?php namespace Nova\Users\Data;

use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Updatable;

class UserUpdater implements Updatable
{
	use BindsData;

	public function update($user)
	{
		$user->update($this->data);

		return $user->fresh();
	}
}
