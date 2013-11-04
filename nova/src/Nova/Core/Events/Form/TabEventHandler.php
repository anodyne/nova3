<?php namespace Nova\Core\Events\Form;

use BaseEventHandler;
use FormSectionModel;
use FormRepositoryInterface;

class TabEventHandler extends BaseEventHandler {

	protected $form;

	public function __construct(FormRepositoryInterface $form)
	{
		// Set the injected interfaces
		$this->form = $form;
	}

	public function onTabCreated($tab)
	{
		// What form are we updating?
		$form = $tab->form;

		// We only have the tab we just created...
		if ($form->tabs->count() == 1)
		{
			// There were no tabs before, but there are sections
			// attached to this form (not sure how that would
			// happen, but let's account for it anyway)
			if ($form->sections->count() > 0)
			{
				foreach ($form->sections as $section)
				{
					// Add the sections to the newly created tab
					$section->update(['tab_id' => $tab->id]);
				}
			}

			// There are fields attached to this form
			if ($form->fields->count() > 0)
			{
				// We don't have any sections
				if ($form->sections->count() == 0)
				{
					// Create a new section
					$newSection = new FormSectionModel([
						'form_id'	=> $form->id,
						'tab_id'	=> $tab->id,
						'name'		=> '',
						'order'		=> 0
					]);

					// Attach the section to the tab
					$tab->sections->save($newSection);

					foreach ($form->fields as $field)
					{
						// Add the fields to the newly created section
						$field->update(['section_id' => $newSection->id]);
					}
				}
				else
				{
					foreach ($form->fields as $field)
					{
						// Add the fields to the first section we find
						$field->update(['section_id' => $tab->sections->first()->id]);
					}
				}
			}
		}

		$this->createSystemEvent(
			'action.created',
			'form tab',
			$tab->form->name,
			'event.admin.form.item'
		);
	}

	public function onTabDeleted($tab, $newTabId)
	{
		// Get the tab's sections
		$sectionIds = $this->form->getTabSections($tab)->toSimpleArray('id', 'id');

		if (count($sectionIds) > 0)
		{
			foreach ($sectionIds as $id)
			{
				$this->form->updateSection($id, ['tab_id' => $newTabId]);
			}
		}

		// Create a system event
		$this->createSystemEvent(
			'action.deleted',
			'form tab',
			$tab->form->name,
			'event.admin.form.item'
		);
		$this->createSystemEvent('action.updated', 'form', $form->name);
	}

	public function onTabUpdated($tab)
	{
		$this->createSystemEvent(
			'action.updated',
			'form tab',
			$tab->form->name,
			'event.admin.form.item'
		);
		$this->createSystemEvent('action.updated', 'form', $form->name);
	}

}