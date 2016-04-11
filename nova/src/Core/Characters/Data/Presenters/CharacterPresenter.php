<?php namespace Nova\Core\Characters\Data\Presenters;

use BasePresenter;

class CharacterPresenter extends BasePresenter {

	public function name()
	{
		$arr = [$this->entity->first_name, $this->entity->last_name];

		return implode(' ', $arr);
	}

}