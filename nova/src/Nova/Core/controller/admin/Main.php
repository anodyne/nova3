<?php namespace Nova\Core\Controller\Admin;

use View;
use Input;
use Sentry;
use Location;
use Redirect;
use SystemRoute;
use AdminBaseController;
use SystemRouteValidator;

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
		// Verify the user is allowed
		Sentry::getUser()->allowed(['pages.create', 'pages.update', 'pages.delete'], true);

		$this->_view = 'admin/main/pages';
		$this->_jsView = 'admin/main/pages_js';

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
					$this->_data->pages['system'][] = $route;
				}
				else
				{
					$this->_data->pages['user'][] = $route;
				}
			}
		}

		// Build the duplicate page modal
		$this->_ajax[] = View::make(Location::file('common/modal', $this->skin, 'partial'))
			->with('modalId', 'duplicatePage')
			->with('modalHeader', ucwords(lang('short.duplicate', langConcat('system page'))))
			->with('modalBody', '')
			->with('modalFooter', false);

		// Build the delete page modal
		$this->_ajax[] = View::make(Location::file('common/modal', $this->skin, 'partial'))
			->with('modalId', 'deletePage')
			->with('modalHeader', ucwords(lang('short.delete', langConcat('system page'))))
			->with('modalBody', '')
			->with('modalFooter', false);
	}
	public function postPages()
	{
		// Set up the validation service
		$validator = new SystemRouteValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
		{
			return Redirect::back()->withInput()->withErrors($validator->getErrors());
		}

		// Get the action
		$action = e(Input::get('action'));

		// Get the current user
		$user = Sentry::getUser();

		/**
		 * Create a new route.
		 */
		if ($user->hasAccess('pages.create') and $action == 'create')
		{
			//
		}

		/**
		 * Duplicate a core route.
		 */
		if ($user->hasAccess('pages.create') and $action == 'duplicate')
		{
			// Get the ID
			$id = e(Input::get('id'));
			$id = (is_numeric($id)) ? $id : false;

			// Get the route we're duplicating
			$route = SystemRoute::find($id);

			// Create the item
			$item = SystemRoute::add([
				'name'		=> $route->name,
				'verb'		=> $route->verb,
				'uri'		=> $route->uri,
				'resource'	=> $route->resource,
			], true);

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? ucfirst(lang('short.alert.success.duplicate', langConcat('system page')))
				: ucfirst(lang('short.alert.failure.duplicate', langConcat('system page')));
		}

		/**
		 * Update a route.
		 */
		if ($user->hasAccess('pages.update') and $action == 'update')
		{
			//
		}

		/**
		 * Delete a route.
		 */
		if ($user->hasAccess('pages.delete') and $action == 'delete')
		{
			// Get the ID
			$id = e(Input::get('id'));
			$id = (is_numeric($id)) ? $id : false;

			if ($id)
			{
				// Delete the route
				SystemRoute::remove($id);

				// Set the flash info
				$flashStatus = 'success';
				$flashMessage = ucfirst(lang('short.alert.success.delete', langConcat('system page')));
			}
			else
			{
				// Set the flash info
				$flashStatus = 'danger';
				$flashMessage = ucfirst(lang('short.alert.failure.delete', langConcat('system page')));
			}
		}

		return Redirect::to('admin/main/pages')
			->with('flashStatus', $flashStatus)
			->with('flashMessage', $flashMessage);
	}

}