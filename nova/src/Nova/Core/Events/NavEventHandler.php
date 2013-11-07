<?php namespace Nova\Core\Events;

class NavEventHandler extends \BaseEventHandler {

	/**
	 * When a nav item is created, create a system event.
	 *
	 * @param	Nav		$item	The nav item that was created
	 * @return	void
	 */
	public function onNavCreated($item)
	{
		$this->createSystemEvent('action.created', 'navigation item', $item->name);
	}

	/**
	 * When a nav item is deleted, create a system event.
	 *
	 * @param	Nav		$item	The nav item that was deleted
	 * @return	void
	 */
	public function onNavDeleted($item)
	{
		$this->createSystemEvent('action.deleted', 'navigation item', $item->name);
	}

	/**
	 * When a nav item is duplicated, create a system event.
	 *
	 * @param	Nav		$item	The nav item that was duplicated
	 * @return	void
	 */
	public function onNavDuplicated($item)
	{
		$this->createSystemEvent('action.duplicated', 'navigation item', $item->name);
	}

	/**
	 * When a nav item is updated, create a system event.
	 *
	 * @param	Nav		$item	The nav item that was updated
	 * @return	void
	 */
	public function onNavUpdated($item)
	{
		$this->createSystemEvent('action.updated', 'navigation item', $item->name);
	}

}