<?php namespace Nova\Core\Forms\Data\Repositories;

use NovaForm,
	NovaFormField as Model,
	FormFieldRepositoryInterface;

class FieldRepository extends BaseFormRepository implements FormFieldRepositoryInterface {

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
		// Handle attributes
		if (array_key_exists('attributeName', $data))
		{
			foreach ($data['attributeName'] as $key => $a)
			{
				$data['attributes'][] = [
					'name' => $a,
					'value' => $data['attributeValue'][$key]
				];
			}
		}

		// Handle values
		if (array_key_exists('optionNames', $data))
		{
			foreach ($data['optionNames'] as $key => $o)
			{
				$data['values'][] = [
					'text' => $o,
					'value' => $data['optionValues'][$key]
				];
			}
		}

		// Handle validation
		if (array_key_exists('ruleType', $data))
		{
			foreach ($data['ruleType'] as $key => $r)
			{
				$data['validation_rules'][] = [
					'type' => $r,
					'value' => $data['ruleValues'][$key]
				];
			}
		}

		// Now create the field
		$field = parent::create($data);

		return $field;
	}

}
