<?php namespace Nova\Core\Forms\Services\FieldTypes;

use Form, Markdown;

class TextField implements FieldTypeInterface {

	public function info()
	{
		return [
			'name' => "Text field",
			'value' => 'text',
			'hasValues' => false,
			'values' => [],
			'attributes' => [
				['name' => 'class', 'value' => 'form-control input-lg'],
				['name' => 'placeholder', 'value' => ''],
				['name' => 'data-foo', 'value' => 'baz'],
			],
			//'preview' => $this->preview(),
			'preview' => '<input type="text" :class="attrClass" :placeholder="attrPlaceholder">',
		];
	}

	public function preview()
	{
		return Form::text('name', null, [':class' => 'attrClass', ':placeholder' => 'attrPlaceholder']);
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
		return Form::text($name, $data, $attributes);
	}

	protected function renderStatic($data)
	{
		return '<p class="form-field-static">'.Markdown::parse($data).'</p>';
	}

}
