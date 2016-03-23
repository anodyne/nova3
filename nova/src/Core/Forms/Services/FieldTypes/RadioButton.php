<?php namespace Nova\Core\Forms\Services\FieldTypes;

use Form, Markdown;

class RadioButton implements FieldTypeInterface {

	public function info()
	{
		return [
			'name' => "Radio buttons",
			'value' => 'radio',
			'hasValues' => true,
			'values' => [],
			'attributes' => [
				['name' => 'class', 'value' => 'form-control input-lg'],
			],
			'baseHTML' => 'radio',
			'fieldContainerSize' => 'col-md-6',
			'labelContainerSize' => 'col-md-2',
		];
	}

	public function render($state, $name, $values, $data, array $attributes)
	{
		if ($state == 'view')
		{
			return $this->renderStatic($data);
		}

		return $this->renderEditable($state, $name, $values, $data, $attributes);
	}

	protected function renderEditable($state, $name, $values, $data, array $attributes)
	{
		return Form::select($name, $values, $data, $attributes);
	}

	protected function renderStatic($data)
	{
		return '<p class="form-field-static">'.Markdown::parse($data).'</p>';
	}

}
