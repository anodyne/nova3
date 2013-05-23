<?php namespace Nova\Core\Controller\Admin;

use Sentry;
use SystemRoute;
use AdminBaseController;

class Main extends AdminBaseController {

	/**
	 * Error Codes
	 */
	const OK 				= 0;
	const NOT_ALLOWED 		= 1;

	public function getIndex()
	{
		$this->_view = 'admin/main/index';

		$this->_data->header = 'Control Panel';
		$this->_data->message = false;

		//s(Sentry::check());
		s($_COOKIE);
	}

	public function getError($code)
	{
		// Set the data
		switch ($code)
		{
			case self::NOT_ALLOWED:
				$this->_data->header = "Not Allowed";
				$this->_data->message = "You don't have permission to view that page.";
			break;
		}
	}

	public function getPages()
	{
		$this->_view = 'admin/main/pages';

		$this->_data->header = 'Page Manager';
		$this->_data->message = false;

		// Get all the routes for the system
		$routes = SystemRoute::get();

		// Make sure we have routes
		if ($routes->count() > 0)
		{
			// Loop through the routes
			foreach ($routes as $route)
			{
				// Separate the routes into CORE and USER routes
				if ((bool) $route->protected === true)
				{
					$this->_data->pages['core'][] = $route;
				}
				else
				{
					$this->_data->pages['user'][] = $route;
				}
			}
		}
	}

}