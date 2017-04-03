<?php namespace Nova\Core\Forms\Policies;

use User;
use NovaForm as Form;
use Nova\Foundation\Policies\Policy;

class FormPolicy extends Policy
{
	protected $createKey = 'form.create';
	protected $editKey = 'form.edit';
	protected $removeKey = 'form.remove';

	public function editEntries(User $user, Form $form)
	{
		return $user->can('form-center.edit');
	}

	public function removeEntries(User $user, Form $form)
	{
		return $user->can('form-center.remove');
	}

	public function viewEntries(User $user, Form $form)
	{
		return $user->can('form-center.view');
	}

	public function viewInFormCenter(User $user, Form $form)
	{
		return $user->canViewForm($form);
	}

	public function editFormCenterEntry(User $user, Form $form)
	{
		return $user->canEditFormEntry($form);
	}

	public function removeFormCenterEntry(User $user, Form $form)
	{
		return $user->canRemoveFormEntry($form);
	}
}
