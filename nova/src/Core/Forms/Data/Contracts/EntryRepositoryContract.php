<?php namespace Nova\Core\Forms\Data\Contracts;

use User;
use NovaForm;

interface EntryRepositoryContract extends BaseFormRepositoryContract
{
	public function getFormEntries(NovaForm $form);
	public function getUserEntries(User $user, $form = null);
	public function insert(NovaForm $form, $user, array $data);
}
