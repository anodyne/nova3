<?php namespace Nova\Users\Presenters;

use Gravatar;
use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter
{
	public function avatarImage()
	{
		if ($this->entity->hasMedia()) {
			return asset("storage/app/public/users/{$this->entity->getPrimaryMedia()->filename}");
		}

		return Gravatar::get($this->entity->email);
	}

	public function name()
	{
		if (! empty($this->entity->nickname)) {
			return $this->entity->nickname;
		}

		return $this->entity->name;
	}
}
