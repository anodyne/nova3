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
		$form = $this->entity->load('tabs', 'tabs.childrenTabs', 'tabs.childrenTabs', 'tabs.childrenTabs.sections', 'tabs.sections');
		$tabs = $form->tabs;
		$parentTabs = $tabs->filter(function ($tab)
		{
			return ! $tab->parent_id;
		});

		return partial('form', compact('form', 'tabs', 'parentTabs'));
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
