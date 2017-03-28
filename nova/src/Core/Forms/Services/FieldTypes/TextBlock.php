<?php namespace Nova\Core\Forms\Services\FieldTypes;

use Form;
use Markdown;

class TextBlock implements FieldTypeInterface
{
	public function info()
	{
		return [
			'name' => "Text Block",
			'value' => 'text-block',
			'hasValues' => false,
			'values' => [],
			'attributes' => [
				['name' => 'class', 'value' => 'form-control input-lg'],
				['name' => 'placeholder', 'value' => ''],
				['name' => 'rows', 'value' => 5],
			],
			'baseHTML' => 'textarea',
			'fieldContainerSize' => 'col-md-8',
			'labelContainerSize' => 'col-md-2',
		];
	}

	public function render($state, $name, $values, $data, array $attributes)
	{
		if ($state == 'view') {
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
		return '<p class="form-field-static">'.Markdown::parse($data).'</p>';
	}
}
