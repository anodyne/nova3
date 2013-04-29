<?php namespace Nova\Core\Handlers;

use App;
use Str;
use UserPrefs;
use SystemEvent;
use NovaFormData;
use NovaFormField;

class User {

	/**
	 * When a user is created, we need to create blank data records
	 * to prevent errors being thrown when the user is updated and
	 * we need to create the user preferences as well.
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function afterCreate($model)
	{
		/**
		 * Create the user settings.
		 */
		$settings = UserPrefs::createUserPreferences($model->id);
		
		/**
		 * Fill the user rows for the dynamic form with blank data for editing later.
		 */
		$fields = NovaFormField::getFormItems('user');
		
		if (count($fields) > 0)
		{
			foreach ($fields as $f)
			{
				NovaFormData::add(array(
					'form_key' 		=> 'user',
					'field_id' 		=> $f->id,
					'data_id' 		=> $model->id,
					'value' 		=> '',
				));
			}
		}

		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.admin.user.item', $model->name, lang('action.created'));
	}

	/**
	 * Post-update observer.
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function afterUpdate($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.admin.user.item', $model->name, lang('action.updated'));
	}

	/**
	 * Pre-delete observer.
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function beforeDelete($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.admin.user.item', $model->name, lang('action.deleted'));
	}

	/**
	 * Before the model is saved, we need to make sure the password
	 * is appropriately hashed. This will happen before every save,
	 * so if the password IS hashed, we have problems.
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function beforeSave($model)
	{
		if (Str::length($model->password) < 96)
		{
			// Get the hasher out of the IoC container
			$hasher = App::make('sentry.hasher');

			// Update the password
			$model->password = $hasher->hash($model->password);
		}
	}

}