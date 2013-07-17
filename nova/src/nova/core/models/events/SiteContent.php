<?php namespace Nova\Core\Models\Events;

use Cache;
use SystemEvent;
use SiteContent as SiteContentModel;

class SiteContent {
	
	/**
	 * After create event
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function created($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.item', lang('base.position'), $model->name, lang('action.created'));
	}

	/**
	 * After update event
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function updated($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.item', lang('base.position'), $model->name, lang('action.updated'));
	}

	/**
	 * Before delete event
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function deleting($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.item', lang('base.position'), $model->name, lang('action.deleted'));
	}

	/**
	 * After the model is saved, we need to blow away the old cache
	 * of settings and replace it with a fresh copy.
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function saved($model)
	{
		// Blow away the old cache
		Cache::forget("nova.content.{$model->type}.{$model->section}");

		// Re-cache the section content
		Cache::forever(
			"nova.content.{$model->type}.{$model->section}", 
			SiteContentModel::getSectionContent($model->type, $model->section)
		);
	}

}