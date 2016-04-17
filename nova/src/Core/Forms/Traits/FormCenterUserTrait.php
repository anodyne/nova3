<?php namespace Nova\Core\Forms\Traits;

use NovaForm;

trait FormCenterUserTrait {
	
	public function canAddFormEntry(NovaForm $form)
	{
		return $this->checkFormEntryStatus('add', $form);
	}

	public function canEditFormEntry(NovaForm $form)
	{
		return $this->checkFormEntryStatus('edit', $form);
	}

	public function canRemoveFormEntry(NovaForm $form)
	{
		return $this->checkFormEntryStatus('remove', $form);
	}

	public function canViewForm(NovaForm $form)
	{
		return $this->checkFormEntryStatus('view', $form);
	}

	public function checkFormEntryStatus($type, NovaForm $form)
	{
		$restriction = $form->restrictions->where('type', $type);

		// If we don't have a restriction, let them access
		if ( ! $restriction)
		{
			return true;
		}

		// Grab the restriction value
		$restrictionValue = $restriction->first()['value'];

		// If there's a restriction, but they selected 'No Restriction', let them access
		if ($restrictionValue == "")
		{
			return true;
		}

		return $this->hasRole($restrictionValue);
	}

}
