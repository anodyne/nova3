<?php namespace Nova\Core\Handlers;

use SystemEvent;
use NovaFormDataModel;
use NovaFormFieldModel;

class Character {

	/**
	 * After create event
	 *
	 * When a character is created, we need to create blank data records
	 * to prevent errors being thrown when the character is updated.
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function afterCreate($model)
	{
		/**
		 * Fill the character rows for the dynamic form with blank data for editing later.
		 */
		$fields = NovaFormFieldModel::getFormItems('character');
		
		if (count($fields) > 0)
		{
			foreach ($fields as $f)
			{
				NovaFormDataModel::add(array(
					'form_key' 	=> 'bio',
					'field_id' 	=> $f->id,
					'data_id'	=> $model->id,
					'value' 	=> '',
				));
			}
		}

		/**
		 * System Event
		 */
		//SystemEvent::addUserEvent('event.admin.rank.item', lang('action.created'));
	}

}