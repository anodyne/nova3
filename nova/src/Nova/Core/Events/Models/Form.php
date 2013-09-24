<?php namespace Nova\Core\Events\Models;

use BaseModelEventHandler;

class Form extends BaseModelEventHandler {

	public static $lang = 'form';
	public static $name = 'name';

	public function deleting($model)
	{
		// Remove all the field data, field values and fields
		if ($model->fields->count() > 0)
		{
			foreach ($model->fields as $field)
			{
				// Remove any data
				if ($field->data->count() > 0)
				{
					foreach ($field->data as $data)
					{
						$data->delete();
					}
				}

				// Remove any field values
				if ($field->values->count() > 0)
				{
					// Remove any values for the field
					foreach ($field->values as $value)
					{
						$value->delete();
					}
				}

				// Remove the field
				$field->delete();
			}
		}

		// Remove the field sections
		if ($model->sections->count() > 0)
		{
			foreach ($model->sections as $section)
			{
				$section->delete();
			}
		}

		// Remove the field tabs
		if ($model->tabs->count() > 0)
		{
			foreach ($model->tabs as $tab)
			{
				$tab->delete();
			}
		}
	}

}