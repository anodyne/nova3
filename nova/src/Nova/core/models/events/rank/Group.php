<?php namespace Nova\Core\Models\Events\Rank;

use SystemEvent;

class Group {

	/**
	 * Post-insert observer.
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function afterCreate($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.admin.rank.group', $model->name, lang('action.created'));
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
		SystemEvent::addUserEvent('event.admin.rank.group', $model->label, lang('action.updated'));
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
		SystemEvent::addUserEvent('event.admin.rank.group', $model->name, lang('action.deleted'));
	}

}