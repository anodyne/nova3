<?php namespace Nova\Core\Events;

class NavigationEventHandler extends \BaseEventHandler {

	/**
	 * When a nav item is created, create a system event.
	 *
	 * @param	Nav		$item	The nav item that was created
	 * @return	void
	 */
	public function onNavCreated($item, $input)
	{
		$this->createSystemEvent('action.created', 'navigation item', $item->name);
	}

	/**
	 * When a nav item is deleted, create a system event.
	 *
	 * @param	Nav		$item	The nav item that was deleted
	 * @return	void
	 */
	public function onNavDeleted($item, $input)
	{
		$this->createSystemEvent('action.deleted', 'navigation item', $item->name);
	}

	/**
	 * When a nav item is duplicated, create a system event.
	 *
	 * @param	Nav		$item	The nav item that was duplicated
	 * @return	void
	 */
	public function onNavDuplicated($item, $input)
	{
		$this->createSystemEvent('action.duplicated', 'navigation item', $item->name);
	}

	/**
	 * When a nav item is updated, create a system event.
	 *
	 * @param	Nav		$item	The nav item that was updated
	 * @return	void
	 */
	public function onNavUpdated($item, $input)
	{
		$this->createSystemEvent('action.updated', 'navigation item', $item->name);
	}

}