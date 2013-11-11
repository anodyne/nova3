<?php namespace Nova\Core\Events;

use SiteContentRepositoryInterface;
use SystemRouteRepositoryInterface;

class SiteContentEventHandler extends \BaseEventHandler {

	protected $route;
	protected $content;

	public function __construct(SiteContentRepositoryInterface $content,
			SystemRouteRepositoryInterface $route)
	{
		$this->route = $route;
		$this->content = $content;
	}

	/**
	 * When a route is created, refresh the site content for that URI and create
	 * a system event.
	 *
	 * @param	SystemRoute		$item	The item that was created
	 * @param	array			$input	Input data
	 * @return	void
	 */
	public function onCreated($item, $input)
	{
		if ((bool) $item->protected === false)
		{
			$this->route->cache();

			// Update the site contents for this URI
			$this->refreshSiteContent($item->name);
		}

		$this->createSystemEvent('action.created', 'system route', $item->name);
	}

	/**
	 * When a route is deleted, refresh the site content for the URI and create
	 * a system event.
	 *
	 * @param	SystemRoute		$item	The item that was deleted
	 * @param	array			$input	Input data
	 * @return	void
	 */
	public function onDeleted($item, $input)
	{
		if ((bool) $item->protected === false)
		{
			$this->route->cache();

			// Update the site contents for this URI
			$this->refreshSiteContent($item->name);
		}

		$this->createSystemEvent('action.deleted', 'system route', $item->name);
	}

	/**
	 * When a route is duplicated, refresh the site content for the URI and
	 * create a system event.
	 *
	 * @param	SystemRoute		$item	The item that was deleted
	 * @param	array			$input	Input data
	 * @return	void
	 */
	public function onDuplicated($item, $input)
	{
		if ((bool) $item->protected === false)
		{
			$this->route->cache();

			// Update the site contents for this URI
			$this->refreshSiteContent($item->name);
		}

		$this->createSystemEvent('action.duplicated', 'system route', $item->name);
	}

	/**
	 * When a route is updated, refresh the site contents and create a 
	 * system event.
	 *
	 * @param	SystemRoute		$item	The item that was updated
	 * @param	array			$input	Input data
	 * @return	void
	 */
	public function onUpdated($item, $input)
	{
		if ((bool) $item->protected === false)
		{
			$this->route->cache();

			// Update the site contents for this URI
			$this->refreshSiteContent($item->name);
		}

		$this->createSystemEvent('action.updated', 'system route', $item->name);
	}

	/**
	 * When we change the route, we have to take into account that site contents
	 * are controlled off the controller name and action, so we need to update
	 * the URI to kick off the process of updating the section and page fields
	 * in the site contents table.
	 *
	 * @internal
	 * @param	string	$uri	The URI
	 * @return	void
	 */
	protected function refreshSiteContent($uri)
	{
		$this->content->updateUri($uri, $uri);
	}

}