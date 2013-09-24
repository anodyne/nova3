<?php namespace Nova\Core\Events\Models;

use BaseModelEventHandler;

class SystemRoute extends BaseModelEventHandler {

	public static $lang = 'system route';
	public static $name = 'name';

	/**
	 * Before delete event
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function deleted($model)
	{
		if ((bool) $model->protected === false)
		{
			\SystemRoute::cache();

			// Update the site contents for this URI
			$this->refreshSiteContent($model->name);
		}

		parent::deleted($model);
	}

	/**
	 * After the model is saved, we need to re-cache the routes,
	 * but only if we're adding an unprotected route (user-created).
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function saved($model)
	{
		if ((bool) $model->protected === false)
		{
			\SystemRoute::cache();
		}
	}

	public function updated($model)
	{
		if ((bool) $model->protected === false)
		{
			// Update the site contents for this URI
			$this->refreshSiteContent($model->name);
		}

		parent::updated($model);
	}

	/**
	 * When we change the route, we have to take into account
	 * that site contents are controlled off the controller
	 * name and action, so we need to update the URI to kick
	 * off the process of updating the section and page fields
	 * in the site contents table.
	 *
	 * @param	string	$uri	The URI
	 * @return	void
	 */
	protected function refreshSiteContent($uri)
	{
		// Get all the site content that uses the URI
		$items = \SiteContent::uri($uri)->get();

		if ($items->count() > 0)
		{
			foreach ($items as $item)
			{
				$item->update(['uri' => $uri]);
			}
		}
	}

}