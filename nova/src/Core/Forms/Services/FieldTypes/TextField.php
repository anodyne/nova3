<?php namespace Nova\Core\Forms\Services\FieldTypes;

use Form;
use HTML;
use Markdown;

class TextField implements FieldTypeInterface
{
	public function info()
	{
		return [
			'name' => "Text Field",
			'value' => 'text-field',
			'hasValues' => false,
			'values' => [],
			'attributes' => [
				['name' => 'class', 'value' => 'form-control input-lg'],
				['name' => 'placeholder', 'value' => ''],
			],
			'baseHTML' => 'text',
			'fieldContainerSize' => 'col-md-4',
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
		return Form::text($name, $data, $attributes);
	}

	protected function renderStatic($data)
	{
		return HTML::tag('p', Markdown::parse($data), ['class' => 'form-control-static']);
	}
}
