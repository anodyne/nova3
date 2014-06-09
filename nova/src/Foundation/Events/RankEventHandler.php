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
	public function onRankCreated($item, $input)
	{
		$this->createSystemEvent('action.created', 'rank', $item->info->name);
	}

	/**
	 * When site content is deleted, re-cache everything and create a 
	 * system event.
	 *
	 * @param	SiteContent		$item	The item that was deleted
	 * @param	array			$input	Input data
	 * @return	void
	 */
	public function onRankDeleted($item, $input)
	{
		$this->createSystemEvent('action.deleted', 'rank', $item->info->name);
	}

	/**
	 * When site content is updated, re-cache everything and create a 
	 * system event.
	 *
	 * @param	SiteContent		$item	The item that was updated
	 * @param	array			$input	Input data
	 * @return	void
	 */
	public function onRankUpdated($item, $input)
	{
		$this->createSystemEvent('action.updated', 'rank', $item->info->name);
	}

	public function onRankGroupCreated($item, $input){}
	public function onRankGroupDeleted($item, $input){}
	public function onRankGroupUpdated($item, $input){}

	public function onRankInfoCreated($item, $input){}
	public function onRankInfoDeleted($item, $input){}
	public function onRankInfoUpdated($item, $input){}

	protected function splitLegacyRanks($item)
	{
		// Find if there's a hyphen in the base image name
		if (Str::contains($item->base, '-'))
		{
			// Break the base image at the hyphen
			list($base, $pip) = explode('-', $item->base);

			// Set the base and pip separately
			$item->base = $base;
			$item->pip = $pip;
		}
	}

}