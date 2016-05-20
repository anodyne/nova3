<?php namespace Nova\Core\Forms\Services\FieldTypes;

use Form, Markdown;

class TextEditor implements FieldTypeInterface {

	public function info()
	{
		return [
			'name' => "Text Editor",
			'value' => 'text-editor',
			'hasValues' => false,
			'values' => [],
			'attributes' => [
				['name' => 'class', 'value' => 'form-control input-lg editor'],
				['name' => 'placeholder', 'value' => ''],
				['name' => 'rows', 'value' => 10],
			],
			'baseHTML' => 'textarea',
			'fieldContainerSize' => 'col-md-8',
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
		return Form::textarea($name, $data, $attributes);
	}

	protected function renderStatic($data)
	{
		return '<p class="form-field-static">'.$data.'</p>';
	}

}
