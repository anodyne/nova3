<?php namespace Nova\Core\Handlers;

use Str;
use SystemEvent;

class Rank {

	/**
	 * After create event
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function afterCreate($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.admin.rank.item', lang('action.created'));
	}

	/**
	 * After update event
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function afterUpdate($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.admin.rank.item', lang('action.updated'));
	}

	/**
	 * Before save event
	 *
	 * Check the base image to see if there's a hyphen in it. If there is, then
	 * we're dealing with a legacy rank and will need to split to make sure everything
	 * works as it should.
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function beforeSave($model)
	{
		// Find if there's a hyphen in the base image name
		if (Str::contains($model->base, '-'))
		{
			// Break the base image at the hyphen
			list($base, $pip) = explode('-', $model->base);

			// Set the base and pip separately
			$model->base = $base;
			$model->pip = $pip;
		}
	}

	/**
	 * Before delete event
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function beforeDelete($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.admin.rank.item', lang('action.deleted'));
	}

}