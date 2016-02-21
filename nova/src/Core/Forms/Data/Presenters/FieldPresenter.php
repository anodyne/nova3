<?php namespace Nova\Core\Forms\Data\Presenters;

use Form;
use Laracasts\Presenter\Presenter;

class FieldPresenter extends Presenter {

	public function render()
	{
		$field = $this->entity;

		switch ($field->type)
		{
			case 'text':
				$attributes = [
					'id' => $field->attribute_id,
					'class' => 'form-control '.$field->attribute_class,
					'placeholder' => $field->attribute_placeholder,
				];

				return Form::text('foo', $field->value, $attributes);
			break;

			case 'textarea':
				$attributes = [
					'id' => $field->attribute_id,
					'class' => 'form-control '.$field->attribute_class,
					'placeholder' => $field->attribute_placeholder,
					'rows' => $field->attribute_rows,
				];

				return Form::textarea('fooarea', $field->value, $attributes);
			break;

			case 'dropdown':
				$attributes = [
					'id' => $field->attribute_id,
					'class' => 'form-control '.$field->attribute_class,
					'placeholder' => $field->attribute_placeholder,
				];

				return Form::select('fooselect', [], $field->value, $attributes);
			break;

			case 'radio':
			break;

			case 'checkbox':
			break;
		}
	}

}
