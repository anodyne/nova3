<?php namespace Nova\Core\Models\Events;

use Cache;
use SystemEvent;
use BaseEventHandler;
use SiteContentRepositoryInterface;

class SiteContent extends BaseEventHandler {

	public static $lang = 'site_content';
	public static $name = 'label';

	public function __construct(SiteContentRepositoryInterface $content)
	{
		$this->content = $content;
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

		// Get the section content (which will cache it)
		$this->content->findBySection($model->type, $model->section, true);
	}

}