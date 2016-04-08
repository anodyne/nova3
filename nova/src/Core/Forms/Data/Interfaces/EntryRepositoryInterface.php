<?php namespace Nova\Core\Forms\Data\Interfaces;

use NovaForm;

interface EntryRepositoryInterface extends BaseFormRepositoryInterface {

	public function insert(NovaForm $form, array $data);

}
