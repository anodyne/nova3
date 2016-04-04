<?php namespace Nova\Core\Forms\Data\Interfaces;

use NovaForm;

interface FormViewerRepositoryInterface extends BaseFormRepositoryInterface {

	public function insertRecord(NovaForm $form, array $data);

}
