<?php namespace Nova\Core\Forms\Services\FieldTypes;

use Form;
use Markdown;
use Illuminate\Support\HtmlString;

class RadioButton implements FieldTypeInterface
{
	public function info()
	{
		return [
			'name' => "Radio Buttons",
			'value' => 'radio',
			'hasValues' => true,
			'values' => [],
			'attributes' => [],
			'baseHTML' => 'radio',
			'fieldContainerSize' => 'col-md-6',
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
		$output = [];

		foreach ($values as $value => $text) {
			$checked = false;

			if ($state == 'edit') {
				$checked = ($value == $data);
			}

			$output[] = new HtmlString(sprintf(
				'<div class="radio"><label>%s %s</label></div>',
				Form::radio($name, $value, $checked, $attributes),
				$text
			));
		}

		return implode('', $output);
	}

	protected function renderStatic($data)
	{
		return '<p class="form-field-static">'.Markdown::parse($data).'</p>';
	}
}
