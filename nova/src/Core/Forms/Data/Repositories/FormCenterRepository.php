<?php namespace Nova\Core\Forms\Data\Repositories;

use NovaForm,
	NovaFormData,
	FormCenterRepositoryInterface;

class FormCenterRepository extends BaseFormRepository implements FormCenterRepositoryInterface {

	public function insertRecord(NovaForm $form, array $data)
	{
		// Grab a copy of the data repo
		$dataRepo = app('FormDataRepository');

		// We don't want the CSRF token in here
		unset($data['_token']);

		// Get the last record submitted for this form
		$lastRecord = $form->data->sortBy('created_by')->last();

		// Now figure out what our data ID should be
		$dataId = ($lastRecord) ? $lastRecord->data_id + 1 : 1;

		foreach ($data as $field => $value)
		{
			preg_match('!\d+!', $field, $matches);
			$fieldId = $matches[0];

			if (is_numeric($fieldId))
			{
				$dataRepo->create([
					'form_id' => $form->id,
					'field_id' => $fieldId,
					'data_id' => $dataId,
					'value' => $value,
					'created_by' => user()->id,
				]);
			}
		}
	}

}
