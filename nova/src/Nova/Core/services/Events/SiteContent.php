<?php namespace Nova\Core\Services\Events;

use Cache;
use SiteContent;
use SystemEvent;

class Settings {
	
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
		SystemEvent::addUserEvent('event.item', lang('base.position'), $model->name, lang('action.created'));
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
		SystemEvent::addUserEvent('event.item', lang('base.position'), $model->name, lang('action.updated'));
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
		SystemEvent::addUserEvent('event.item', lang('base.position'), $model->name, lang('action.deleted'));
	}

	/**
	 * After the model is saved, we need to blow away the old cache
	 * of settings and replace it with a fresh copy.
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function afterSave($model)
	{
		// Blow away the old cache
		Cache::forget("nova.content.{$model->type}.{$model->section}");

		// Re-cache the section content
		Cache::forever(
			"nova.content.{$model->type}.{$model->section}", 
			SiteContent::getSectionContent($model->type, $model->section)
		);
	}

}