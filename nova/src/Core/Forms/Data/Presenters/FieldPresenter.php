<?php namespace Nova\Core\Forms\Data\Presenters;

use Form, Markdown;
use Laracasts\Presenter\Presenter;

class FieldPresenter extends Presenter {

	public function help()
	{
		return Markdown::parse($this->entity->help);
	}

	public function render()
	{
		$field = $this->entity;

		switch ($field->type)
		{
			case 'text':
				$attributes = [
					'id' => $field->attribute_id,
					'class' => 'form-control input-lg '.$field->attribute_class,
					'placeholder' => $field->attribute_placeholder,
				];

				return Form::text($field->attribute_name, $field->value, $attributes);
			break;

			case 'textarea':
				$attributes = [
					'id' => $field->attribute_id,
					'class' => 'form-control '.$field->attribute_class,
					'placeholder' => $field->attribute_placeholder,
					'rows' => $field->attribute_rows,
				];

				return Form::textarea($field->attribute_name, $field->value, $attributes);
			break;

			case 'dropdown':
				$attributes = [
					'id' => $field->attribute_id,
					'class' => 'form-control '.$field->attribute_class,
					'placeholder' => $field->attribute_placeholder,
				];

				return Form::select($field->attribute_name, [], $field->value, $attributes);
			break;

			case 'radio':
			break;

			case 'checkbox':
			break;
		}
	}

}
