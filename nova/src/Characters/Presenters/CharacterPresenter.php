<?php namespace Nova\Characters\Presenters;

use Gravatar;
use Laracasts\Presenter\Presenter;

class CharacterPresenter extends Presenter
{
	public function avatarImage()
	{
		if ($this->entity->hasMedia()) {
			return asset("storage/app/public/characters/{$this->entity->getPrimaryMedia()->filename}");
		}

		return Gravatar::image($this->entity->user->email, null, null, null, true).'?s=240&d=mm&r=pg';
	}
}
