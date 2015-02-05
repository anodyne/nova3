<?php namespace Nova\Core\Pages\Data\Presenters;

use Laracasts\Presenter\Presenter;

class PagePresenter extends Presenter {

	public function message()
	{
		if ($this->entity->message())
			return app('nova.markdown')->parse($this->entity->message()->present()->value);
	}

	public function header()
	{
		if ($this->entity->header())
			return $this->entity->header()->present()->value;
	}

	public function title()
	{
		if ($this->entity->title())
			return $this->entity->title()->present()->value;
	}

}
