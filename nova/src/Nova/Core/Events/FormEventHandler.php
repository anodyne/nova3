<?php namespace Nova\Core\Events;

use BaseEventHandler;

class FormEventHandler extends BaseEventHandler {

	/**
	 * When a form is created, create a system event.
	 *
	 * @param	Form	$form	The form that was created
	 * @return	void
	 */
	public function onFormCreated($form)
	{
		$this->createSystemEvent('action.created', 'form', $form->name);
	}

	/**
	 * When a form is deleted, make sure we clean up any additional items that
	 * are attached to the form. At the end, create a system event as well.
	 *
	 * @param	Form	$form	The form that was deleted
	 * @return	void
	 */
	public function onFormDeleted($form)
	{
		// Remove all the field data, field values and fields
		if ($form->fields->count() > 0)
		{
			foreach ($form->fields as $field)
			{
				// Remove any data
				if ($field->data->count() > 0)
				{
					foreach ($field->data as $data)
					{
						$data->delete();
					}
				}

				// Remove any field values
				if ($field->values->count() > 0)
				{
					// Remove any values for the field
					foreach ($field->values as $value)
					{
						$value->delete();
					}
				}

				// Remove the field
				$field->delete();
			}
		}

		// Remove the field sections
		if ($form->sections->count() > 0)
		{
			foreach ($form->sections as $section)
			{
				$section->delete();
			}
		}

		// Remove the field tabs
		if ($form->tabs->count() > 0)
		{
			foreach ($form->tabs as $tab)
			{
				$tab->delete();
			}
		}

		$this->createSystemEvent('action.deleted', 'form', $form->name);
	}

	/**
	 * When a form is updated, create a system event.
	 *
	 * @param	Form	$form	The form that was updated
	 * @return	void
	 */
	public function onFormUpdated($form)
	{
		$this->createSystemEvent('action.updated', 'form', $form->name);
	}

}