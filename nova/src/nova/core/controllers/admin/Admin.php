<?php namespace Nova\Core\Controllers\Admin;

use View;
use Input;
use Sentry;
use Location;
use Redirect;
use SystemRoute;
use AdminBaseController;
use SystemRouteValidator;

class Admin extends AdminBaseController {

	/**
	 * Error Codes
	 */
	const OK 				= 0;
	const NOT_ALLOWED 		= 1;

	public function getIndex()
	{
		$this->_view = 'admin/admin/index';

		$this->_data->header = 'Control Panel';
		$this->_data->message = false;

		//s(Sentry::check());
		//s($_COOKIE);
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

	public function getRoutes($id = false)
	{
		// Verify the user is allowed
		Sentry::getUser()->allowed(['routes.create', 'routes.update', 'routes.delete'], true);

		$this->_jsView = 'admin/admin/routes_js';

		if ($id !== false)
		{
			$this->_view = 'admin/admin/routes_action';

			// Set the ID
			$id = (is_numeric($id)) ? $id : 0;

			// Get the route
			$this->_data->route = SystemRoute::find($id);

			// Set the action
			$this->_mode = $this->_data->action = ((int) $id === 0) ? 'create' : 'update';
		}
		else
		{
			$this->_view = 'admin/admin/routes';

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
						$this->_data->routes['core'][] = $route;
					}
					else
					{
						$this->_data->routes['user'][] = $route;
					}
				}
			}

			// Build the duplicate page modal
			$this->_ajax[] = View::make(Location::partial('common/modal'))
				->with('modalId', 'duplicateRoute')
				->with('modalHeader', ucwords(lang('short.duplicate', langConcat('core route'))))
				->with('modalBody', false)
				->with('modalFooter', false);

			// Build the delete page modal
			$this->_ajax[] = View::make(Location::partial('common/modal'))
				->with('modalId', 'deleteRoute')
				->with('modalHeader', ucwords(lang('short.delete', lang('route'))))
				->with('modalBody', false)
				->with('modalFooter', false);
		}
	}
	public function postRoutes()
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
		if ($user->hasAccess('routes.create') and $action == 'create')
		{
			// Create the new page route
			$item = SystemRoute::create(Input::all());

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? ucfirst(lang('short.alert.success.create', lang('route')))
				: ucfirst(lang('short.alert.failure.create', lang('route')));
		}

		/**
		 * Duplicate a core route.
		 */
		if ($user->hasAccess('routes.create') and $action == 'duplicate')
		{
			// Get the ID
			$id = e(Input::get('id'));
			$id = (is_numeric($id)) ? $id : false;

			// Get the route we're duplicating
			$route = SystemRoute::find($id);

			// Create the item
			$item = SystemRoute::create([
				'name'		=> $route->name,
				'verb'		=> $route->verb,
				'uri'		=> $route->uri,
				'resource'	=> $route->resource,
			]);

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? ucfirst(lang('short.alert.success.duplicate', langConcat('core route')))
				: ucfirst(lang('short.alert.failure.duplicate', langConcat('core route')));
		}

		/**
		 * Update a route.
		 */
		if ($user->hasAccess('routes.update') and $action == 'update')
		{
			// Get the ID
			$id = e(Input::get('id'));
			$id = (is_numeric($id)) ? $id : false;

			if ($id)
			{
				// Get the route
				$item = SystemRoute::find($id);

				// Update the route
				$item->update(Input::all());
			}

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? ucfirst(lang('short.alert.success.update', lang('route')))
				: ucfirst(lang('short.alert.failure.update', lang('route')));
		}

		/**
		 * Delete a route.
		 */
		if ($user->hasAccess('routes.delete') and $action == 'delete')
		{
			// Get the ID
			$id = e(Input::get('id'));
			$id = (is_numeric($id)) ? $id : false;

			if ($id)
			{
				// Delete the route
				SystemRoute::destroy($id);

				// Set the flash info
				$flashStatus = 'success';
				$flashMessage = ucfirst(lang('short.alert.success.delete', lang('route')));
			}
			else
			{
				// Set the flash info
				$flashStatus = 'danger';
				$flashMessage = ucfirst(lang('short.alert.failure.delete', lang('route')));
			}
		}

		return Redirect::to('admin/routes')
			->with('flashStatus', $flashStatus)
			->with('flashMessage', $flashMessage);
	}

}