<?php namespace Nova\Core\Forms\Data\Presenters;

use Form,
	Status,
	Markdown,
	BasePresenter;

class FieldPresenter extends BasePresenter {

	public function help()
	{
		return Markdown::parse($this->entity->help);
	}

	public function render($id = null, $fieldState = 'view', $fieldNameWrapper = null)
	{
		$state = ($id === null) ? 'create' : $fieldState;

		$field = $this->entity;

		// Build the field name
		$fieldName = sprintf(config('nova.forms.fieldNameFormat'), $field->id);
		$fieldName = ($fieldNameWrapper) ? sprintf($fieldNameWrapper, $fieldName) : $fieldName;

		// Grab the data if we need to
		$data = ($field->data) ? $field->data->whereLoose('data_id', $id) : null;
		$fieldValue = ($data->count() > 0) ? $data->first()->value : null;

		// Build some arrays for the field attributes and values (if necessary)
		$attributesArr = [];
		$valuesArr = [];

		if ($field->attributes)
		{
			$field->attributes->each(function ($item) use (&$attributesArr) {
				$attributesArr[$item['name']] = $item['value'];
			});
		}

		if ($field->values)
		{
			$field->values->each(function ($item) use (&$valuesArr) {
				$valuesArr[$item['value']] = $item['text'];
			});
		}

		return app('nova.forms.fields')
			->getFieldType($field->type)
			->render($state, $fieldName, $valuesArr, $fieldValue, $attributesArr);
	}

	public function statusAsLabel()
	{
		if ($this->entity->status != Status::ACTIVE)
		{
			return label('danger', ucwords(Status::toString($this->entity->status)));
		}
	}

}
