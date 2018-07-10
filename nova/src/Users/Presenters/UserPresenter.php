<?php namespace Nova\Users\Presenters;

use Gravatar;
use Nova\Foundation\Presenters\Presenter;

class UserPresenter extends Presenter
{
	public function avatarImage()
	{
		if ($this->entity->hasMedia()) {
			return asset("storage/app/public/users/{$this->entity->getPrimaryMedia()->filename}");
		}

		if (! empty($this->entity->email)) {
			return Gravatar::get($this->entity->email);
		}

		return false;
	}
}
