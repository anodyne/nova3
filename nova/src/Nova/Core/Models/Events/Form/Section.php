<?php namespace Nova\Core\Models\Events\Form;

/**
 * Form section event handler.
 *
 * created
 * When a new section is added, we need to check to see how many sections
 * exist already. If there's only 1 (i.e. the one we just created) then we
 * need to update all of the fields for that form to move them in to the
 * newly created section otherwise we won't have access to edit the fields
 * any more.
 *
 * When a new section is created, we need to check the containing tab's
 * status to figure out if we should be activating/deactivating the tab.
 *
 * updated
 * When a section is updated, we need to check that tab's sections to see
 * how we should handle activating/deactivating tabs based on the sections.
 *
 * deleting
 * When a section is deleted, we need to loop through its tab sections
 * and see if we should be activating/deactivating any tabs.
 */

use Status;
use SystemEvent;
use NovaFormSection;
use BaseEventHandler;

class Section extends BaseEventHandler {

	public function created($model)
	{
		// What form are we updating?
		$form = $model->form;

		// We only have the section we just created
		if ($form->sections->count() == 1)
		{
			// We have some orphaned fields
			if ($form->fields->count() > 0)
			{
				// Loop through the orphaned fields and add them to the
				// section we just created
				foreach ($form->fields as $f)
				{
					$f->section_id = $model->id;
					$f->save();
				}
			}
		}

		/**
		 * Tab cleanup
		 */
		
		// The section is assigned to a tab
		if ($model->tab_id > 0)
		{
			// The tab has a section
			if ($model->tab->sections->count() > 0)
			{
				// Loop through the sections in the tab and get the 
				// information about their status
				foreach ($model->tab->sections as $s)
				{
					$active[$s->id] = (int) $s->status;
				}

				// Get a count of the different values
				$activeCount = array_count_values($active);

				// If there are no active sections OR the number of actives is more than 0
				if (in_array(Status::ACTIVE, $active) 
						or (array_key_exists(1, $activeCount) and $activeCount[1] > 0))
				{
					// This tab was previous disabled, but we need to re-enable it now
					if ($model->tab->status === Status::INACTIVE)
					{
						$model->tab->status = Status::ACTIVE;
						$model->tab->save();
					}
				}
			}
			else
			{
				// The tab was previously enabled but needs to be disabled now
				// because there are no longer sections in the tab
				if ($model->tab->status === Status::ACTIVE)
				{
					$model->tab->status = Status::INACTIVE;
					$model->tab->save();
				}
			}
		}

		/**
		 * System Event
		 */
		SystemEvent::addUserEvent(
			'event.admin.form.item',
			$model->name,
			langConcat('form section'),
			$model->form->name,
			lang('action.created')
		);
	}

	public function updated($model)
	{
		/**
		 * Tab cleanup
		 */

		// The section is assigned to a tab
		if ($model->tab_id > 0)
		{
			// The tab has a section
			if ($model->tab->sections->count() > 0)
			{
				// Loop through the sections and get the 
				// information about its status
				foreach ($model->tab->sections as $s)
				{
					$active[$s->id] = (int) $s->status;
				}

				// Get a count of the different values
				$activeCount = array_count_values($active);

				// If there are no active sections OR the number of actives is only 1
				if ( ! in_array(Status::ACTIVE, $active) 
						or (array_key_exists(1, $activeCount) and $activeCount[1] == 0))
				{
					// Disable a previously enabled tab
					if ($model->tab->status === Status::ACTIVE)
					{
						$model->tab->status = Status::INACTIVE;
						$model->tab->save();
					}
				}
				else
				{
					// Enable a previously disabled tab
					if ($model->tab->status === Status::INACTIVE)
					{
						$model->tab->status = Status::ACTIVE;
						$model->tab->save();
					}
				}
			}
			else
			{
				// Disable a previously enabled tab
				if ($model->tab->status === Status::ACTIVE)
				{
					$model->tab->status = Status::INACTIVE;
					$model->tab->save();
				}
			}
		}

		/**
		 * System Event
		 */
		SystemEvent::addUserEvent(
			'event.admin.form.item',
			$model->name,
			langConcat('form section'),
			$model->form->name,
			lang('action.updated')
		);
	}

	public function deleting($model)
	{
		/**
		 * Tab cleanup
		 */

		// The section is assigned to a tab
		if ($model->tab_id > 0)
		{
			// The tab has sections
			if ($model->tab->sections->count() > 0)
			{
				// Loop through the sections and get the
				// information about its status
				foreach ($model->tab->sections as $s)
				{
					$active[$s->id] = (int) $s->status;
				}

				// Get a count of the different values
				$activeCount = array_count_values($active);

				// If there are no active sections OR the number of actives is less
				// than 2 (the current section removal would make it 0)
				if ( ! in_array(Status::ACTIVE, $active) 
						or (array_key_exists(1, $activeCount) and $activeCount[1] < 2))
				{
					// Disable and previously enabled tab
					if ($model->tab->status === Status::ACTIVE)
					{
						$model->tab->status = Status::INACTIVE;
						$model->tab->save();
					}
				}
			}
			else
			{
				// Disable a previously enabled tab
				if ($model->tab->status === Status::ACTIVE)
				{
					$model->tab->status = Status::INACTIVE;
					$model->tab->save();
				}
			}
		}
	}

	public function deleted($model)
	{
		SystemEvent::addUserEvent(
			'event.admin.form.item',
			$model->name,
			langConcat('form section'),
			$model->form->name,
			lang('action.deleted')
		);
	}

}