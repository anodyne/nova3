<?php namespace Nova\Core\Models\Events;

use Cache;
use SystemEvent;
use BaseEventHandler;

class SiteContent extends BaseEventHandler {

	public static $lang = 'site_content';
	public static $name = 'label';

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
			\SiteContent::getSectionContent($model->type, $model->section)
		);
	}

}