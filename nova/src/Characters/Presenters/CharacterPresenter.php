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

		return asset("assets/images/no-avatar.svg");
	}

	public function name()
	{
		return join(' ', [
			($this->entity->rank) ? $this->entity->rank->info->name : null,
			$this->entity->name
		]);
	}
}
