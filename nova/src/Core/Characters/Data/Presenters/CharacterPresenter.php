<?php namespace Nova\Core\Characters\Data\Presenters;

use Laracasts\Presenter\Presenter;

class CharacterPresenter extends Presenter {

	public function name()
	{
		$arr = [$this->entity->first_name, $this->entity->last_name];

		return implode(' ', $arr);
	}

}