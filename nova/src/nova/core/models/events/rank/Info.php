<?php namespace Nova\Core\Models\Events\Rank;

use SystemEvent;

class Info {

	/**
	 * Post-insert observer.
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function created($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.admin.rank.info', $model->name, lang('action.created'));
	}

	/**
	 * Post-update observer.
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function updated($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.admin.rank.info', $model->label, lang('action.updated'));
	}

	/**
	 * Pre-delete observer.
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function deleting($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.admin.rank.info', $model->name, lang('action.deleted'));
	}

}