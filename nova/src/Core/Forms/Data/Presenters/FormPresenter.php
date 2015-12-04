<?php namespace Nova\Core\Forms\Data\Presenters;

use Status;
use Laracasts\Presenter\Presenter;

class FormPresenter extends Presenter {

	public function renderViewForm($id)
	{
		# code...
	}

	public function renderNewForm()
	{
		# code...
	}

	public function renderEditForm($id)
	{
		# code...
	}

	public function statusAsLabel()
	{
		if ($this->entity->status != Status::ACTIVE)
		{
			return label('danger', ucwords(Status::toString($this->entity->status)));
		}
	}

}
