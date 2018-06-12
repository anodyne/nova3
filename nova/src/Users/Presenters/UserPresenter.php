<?php namespace Nova\Users\Presenters;

use Gravatar;
use Nova\Foundation\Presenters\Presenter;

class UserPresenter extends Presenter
{
	public function presentAvatarImage()
	{
		if ($this->hasMedia()) {
			return asset("storage/app/public/users/{$this->getPrimaryMedia()->filename}");
		}

		if (! empty($this->email)) {
			return Gravatar::get($this->email);
		}

		return false;
	}
}
