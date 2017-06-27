<?php namespace Nova\Users\Presenters;

use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter
{
	public function name()
	{
		if (! empty($this->entity->nickname)) {
			return $this->entity->nickname;
		}

		return $this->entity->name;
	}
}
