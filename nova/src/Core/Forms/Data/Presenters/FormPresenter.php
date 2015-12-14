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
		$form = $this->entity->load('parentTabs', 'parentTabs.childrenTabs', 'parentTabs.childrenTabs', 'parentTabs.childrenTabs.sections', 'parentTabs.childrenTabs.sections.fields', 'parentTabs.sections', 'parentTabs.sections.fields');

		$tabs = $form->parentTabs;

		return partial('form-editable', compact('form', 'tabs'));
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
