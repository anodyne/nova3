<?php namespace Nova\Core\Forms\Data\Interfaces;

use NovaForm;

interface FormCenterRepositoryInterface extends BaseFormRepositoryInterface {

	public function insertRecord(NovaForm $form, array $data);

}
