<?php namespace Nova\Core\Forms\Data\Presenters;

use Status;
use Laracasts\Presenter\Presenter;

class FormPresenter extends Presenter {

	public function hasHorizontalOrientation()
	{
		return $this->entity->orientation == 'horizontal';
	}

	public function hasVerticalOrientation()
	{
		return $this->entity->orientation == 'vertical';
	}

	public function renderViewForm($id)
	{
		# code...
	}

	public function renderNewForm()
	{
		$form = $this->entity->load('parentTabs', 'parentTabs.childrenTabs', 'parentTabs.childrenTabs', 'parentTabs.childrenTabs.sections', 'parentTabs.childrenTabs.sections.fields', 'parentTabs.sections', 'parentTabs.sections.fields');

		$tabs = $form->parentTabs;

		$sections = $form->sectionsUnbound;

		return partial('form-editable', compact('form', 'tabs', 'sections'));
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
