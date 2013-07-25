<?php namespace Nova\Core\Models\Events;

use NovaForm;
use SystemEvent;
use NovaFormData;
use BaseEventHandler;

class User extends BaseEventHandler {

	public static $lang = 'user';
	public static $name = 'name';

	/**
	 * When a user is created, we need to create blank data records
	 * to prevent errors being thrown when the user is updated and
	 * we need to create the user preferences as well.
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function created($model)
	{
		/**
		 * Create the user settings.
		 */
		$model->createUserPreferences();
		
		/**
		 * Fill the user rows for the dynamic form with blank data for editing later.
		 */
		$form = NovaForm::key('user')->first();
		
		if ($form->fields->count() > 0)
		{
			foreach ($form->fields as $field)
			{
				NovaFormData::create([
					'form_id' 	=> $form->id,
					'field_id' 	=> $field->id,
					'data_id' 	=> $model->id,
					'value' 	=> '',
				]);
			}
		}

		// Call the parent
		parent::created();
	}

}