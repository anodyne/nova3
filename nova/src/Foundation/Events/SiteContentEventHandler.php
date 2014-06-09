<?php namespace Nova\Core\Events;

use Cache;
use SiteContentRepositoryInterface;

class SiteContentEventHandler extends \BaseEventHandler {

	protected $content;

	public function __construct(SiteContentRepositoryInterface $content)
	{
		$this->content = $content;
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
		// Re-cache the site content
		$this->recache($item);

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
		// Re-cache the site content
		$this->recache($item);

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
		// Re-cache the site content
		$this->recache($item);

		$this->createSystemEvent('action.updated', 'site content', $item->label);
	}

	/**
	 * Re-cache the site content for the type and section.
	 *
	 * @internal
	 * @param	SiteContent		$item	The content item
	 * @return	void
	 */
	protected function recache($item)
	{
		// Blow away the old cache
		Cache::forget("nova.content.{$item->type}.{$item->section}");

		// Get the section content (which will cache it)
		$this->content->findBySection($item->type, $item->section, true);
	}

}