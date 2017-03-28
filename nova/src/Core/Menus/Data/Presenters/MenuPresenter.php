<?php namespace Nova\Core\Menus\Data\Presenters;

use BasePresenter;

class MenuPresenter extends BasePresenter
{
	public function key()
	{
		return $this->entity->key;
	}
	
	public function name()
	{
		return $this->entity->name;
	}
}
