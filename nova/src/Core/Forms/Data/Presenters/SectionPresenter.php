<?php namespace Nova\Core\Forms\Data\Presenters;

use Status;
use Markdown;
use BasePresenter;

class SectionPresenter extends BasePresenter
{
	public function message()
	{
		return Markdown::parse($this->entity->message);
	}

	public function statusAsLabel()
	{
		if ($this->entity->status != Status::ACTIVE) {
			return label('danger', ucwords(Status::toString($this->entity->status)));
		}
	}
}
