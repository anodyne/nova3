<?php namespace Nova\Core\Menus\Data\Presenters;

use Laracasts\Presenter\Presenter;

class MenuPresenter extends Presenter {

	public function key()
	{
		return $this->entity->key;
	}
	
	public function name()
	{
		return $this->entity->name;
	}

}
