<?php namespace Nova\Core\Forms\Data\Presenters;

use Status, Markdown;
use Laracasts\Presenter\Presenter;

class TabPresenter extends Presenter {

	public function message()
	{
		return Markdown::parse($this->entity->message);
	}

	public function statusAsLabel()
	{
		if ($this->entity->status != Status::ACTIVE)
		{
			return label('danger', ucwords(Status::toString($this->entity->status)));
		}
	}
	
}
