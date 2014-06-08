<?php namespace Nove\Core\Events;

use Cache;
use SettingsRepositoryInterface;

class SettingsEventHandler extends \BaseEventHandler {

	protected $settings;

	public function __construct(SettingsRepositoryInterface $settings)
	{
		$this->settings = $settings;
	}

	/**
	 * When site content is created, re-cache everything and create a 
	 * system event.
	 *
	 * @param	SiteContent		$item	The item that was created
	 * @param	array			$input	Input data
	 * @return	void
	 */
	public function onCreated($item, $input)
	{
		// Re-cache everything
		$this->recache();

		$this->createSystemEvent('action.created', 'site content', $item->label);
	}

	/**
	 * When site content is deleted, re-cache everything and create a 
	 * system event.
	 *
	 * @param	SiteContent		$item	The item that was deleted
	 * @param	array			$input	Input data
	 * @return	void
	 */
	public function onDeleted($item, $input)
	{
		// Re-cache everything
		$this->recache();
		
		$this->createSystemEvent('action.deleted', 'site content', $item->label);
	}

	/**
	 * When site content is updated, re-cache everything and create a 
	 * system event.
	 *
	 * @param	SiteContent		$item	The item that was updated
	 * @param	array			$input	Input data
	 * @return	void
	 */
	public function onUpdated($item, $input)
	{
		// Re-cache everything
		$this->recache();

		$this->createSystemEvent('action.updated', 'site content', $item->label);
	}

	/**
	 * Re-cache the site content for the type and section.
	 *
	 * @internal
	 * @param	SiteContent		$item	The content item
	 * @return	void
	 */
	protected function recache()
	{
		// Blow away the old cache
		//Cache::forget('nova.settings');

		// Re-cache everything
		//Cache::forever('nova.settings', $this->settings->getItems(false, false));
	}

}