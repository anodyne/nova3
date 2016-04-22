<?php namespace Nova\Core\Forms\Data\Repositories;

use NovaForm,
	NovaFormField as Model,
	FormFieldRepositoryContract;
use Nova\Core\Forms\Events;

class FieldRepository extends BaseFormRepository implements FormFieldRepositoryContract {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	/**
	 * We need to modify the way we create a field to allow for handling
	 * attributes, values, and validation rules being stored as JSON in
	 * the database.
	 */
	public function create(array $data)
	{
		// Clean up the data
		$data = $this->cleanFieldValues($data);

		// Now create the field
		$field = parent::create($data);

		event(new Events\FormFieldCreated($field));

		return $field;
	}

	public function delete($resource)
	{
		$field = parent::delete($resource);

		event(new Events\FormFieldDeleted($field->id, $field->label, $field->form->key));

		return $field;
	}

	/**
	 * We need to modify the way we update a field to allow for handling
	 * attributes, values, and validation rules being stored as JSON in
	 * the database.
	 */
	public function update($resource, array $data)
	{
		// Clean up the data
		$data = $this->cleanFieldValues($data);

		// Now update the field
		$field = parent::update($resource, $data);

		event(new Events\FormFieldUpdated($field));

		return $field;
	}

	public function updateOrder($resource, $newOrder)
	{
		$field = parent::updateOrder($resource, $newOrder);

		event(new Events\FormFieldOrderUpdated($field));

		return $field;
	}

	protected function cleanFieldValues(array $data)
	{
		// Handle attributes
		if (array_key_exists('attributeNames', $data))
		{
			foreach ($data['attributeNames'] as $key => $a)
			{
				if ( ! empty($a))
				{
					$data['attributes'][] = [
						'name' => $a,
						'value' => $data['attributeValues'][$key]
					];
				}
			}

			unset($data['attributeNames']);
			unset($data['attributeValues']);
		}

		// Handle values
		if (array_key_exists('optionNames', $data) and ($data['type'] == 'select' or $data['type'] == 'radio'))
		{
			foreach ($data['optionNames'] as $key => $o)
			{
				$data['values'][] = [
					'text' => $o,
					'value' => $data['optionValues'][$key]
				];
			}

			unset($data['optionNames']);
			unset($data['optionValues']);
		}

		// Handle validation
		if (array_key_exists('ruleTypes', $data))
		{
			foreach ($data['ruleTypes'] as $key => $r)
			{
				if ( ! empty($r))
				{
					$data['validation_rules'][] = [
						'type' => $r,
						'value' => $data['ruleValues'][$key]
					];
				}
			}

			unset($data['ruleType']);
			unset($data['ruleValues']);
		}

		// Handle restrictions
		if (array_key_exists('restrictionValues', $data))
		{
			foreach ($data['restrictionValues'] as $type => $value)
			{
				$data['restrictions'][] = [
					'type' => $type,
					'value' => $value,
				];
			}

			unset($data['restrictionValues']);
		}

		return $data;
	}

}
