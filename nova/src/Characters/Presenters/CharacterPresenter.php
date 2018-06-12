<?php namespace Nova\Characters\Presenters;

use Gravatar;
use Nova\Foundation\Presenters\Presenter;

class CharacterPresenter extends Presenter
{
	public function presentAvatarImage()
	{
		if ($this->hasMedia()) {
			return asset("storage/app/public/characters/{$this->getPrimaryMedia()->filename}");
		}

		return asset("nova/resources/assets/svg/no-avatar.svg");
	}

	public function presentName()
	{
		return join(' ', [
			($this->rank) ? $this->rank->info->short_name : null,
			$this->object->name
		]);
	}
}
