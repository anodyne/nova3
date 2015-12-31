<?php namespace Nova\Core\Forms\Data\Presenters;

use Status;
use Laracasts\Presenter\Presenter;

class SectionPresenter extends Presenter {

	public function statusAsLabel()
	{
		if ($this->entity->status != Status::ACTIVE)
		{
			return label('danger', ucwords(Status::toString($this->entity->status)));
		}
	}
	
}
