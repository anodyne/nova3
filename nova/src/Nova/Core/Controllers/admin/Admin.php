<?php namespace Nova\Core\Controllers\Admin;

use View;
use Input;
use Location;
use Redirect;
use ErrorCode;
use AdminBaseController;
use SystemRouteValidator;
use SiteContentRepositoryInterface;
use SystemRouteRepositoryInterface;

class Admin extends AdminBaseController {

	public function __construct(SiteContentRepositoryInterface $content,
			SystemRouteRepositoryInterface $route)
	{
		parent::__construct($content);

		// Set the injected interfaces
		$this->route = $route;
	}

	public function getIndex()
	{
		$this->_view = 'admin/admin/index';

		$this->_data->header = 'Control Panel';
		$this->_data->message = false;
	}

	public function getError($code)
	{
		// Set the data
		switch ($code)
		{
			case ErrorCode::ADMIN_NOT_ALLOWED:
				$this->_data->header = "Not Allowed";
				$this->_data->message = "You don't have permission to view that page.";
			break;
		}
	}

	public function getRoutes($id = false)
	{
		// Verify the user is allowed
		$this->currentUser->allowed(['routes.create', 'routes.update', 'routes.delete'], true);

		$this->_jsView = 'admin/admin/routes_js';

		if ($id !== false)
		{
			$this->_view = 'admin/admin/routes_action';

			// Set the ID
			$routeId = (is_numeric($id)) ? $id : 0;

			// Get the route
			$route = $this->_data->route = $this->route->find($routeId);

			// Set the action
			$this->_mode = $this->_data->action = ((int) $routeId === 0) ? 'create' : 'update';
		}
		else
		{
			$this->_view = 'admin/admin/routes';

			// Get all the routes for the system
			$routes = $this->route->all();

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
				->with('modalHeader', lang('Short.duplicate', langConcat('Core Route')))
				->with('modalBody', false)
				->with('modalFooter', false);

			// Build the delete page modal
			$this->_ajax[] = View::make(Location::partial('common/modal'))
				->with('modalId', 'deleteRoute')
				->with('modalHeader', lang('Short.delete', lang('Route')))
				->with('modalBody', false)
				->with('modalFooter', false);
		}
	}
	public function postRoutes()
	{
		// Get the action
		$action = e(Input::get('formAction'));

		// Set up the validation service
		$validator = new SystemRouteValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
		{
			return Redirect::back()->withInput()->withErrors($validator->getErrors());
		}

		/**
		 * Create a new route.
		 */
		if ($this->currentUser->hasAccess('routes.create') and $action == 'create')
		{
			// Create the new page route
			$item = $this->route->create(Input::all());

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? ucfirst(lang('short.alert.success.create', lang('route')))
				: ucfirst(lang('short.alert.failure.create', lang('route')));
		}

		/**
		 * Duplicate a core route.
		 */
		if ($this->currentUser->hasAccess('routes.create') and $action == 'duplicate')
		{
			// Duplicate the route
			$item = $this->route->duplicate(Input::get('id'));

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? ucfirst(lang('short.alert.success.duplicate', langConcat('core route')))
				: ucfirst(lang('short.alert.failure.duplicate', langConcat('core route')));
		}

		/**
		 * Update a route.
		 */
		if ($this->currentUser->hasAccess('routes.update') and $action == 'update')
		{
			// Update the route
			$item = $this->route->update(Input::get('id'), Input::all());

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? ucfirst(lang('short.alert.success.update', lang('route')))
				: ucfirst(lang('short.alert.failure.update', lang('route')));
		}

		/**
		 * Delete a route.
		 */
		if ($this->currentUser->hasAccess('routes.delete') and $action == 'delete')
		{
			// Delete the route
			$item = $this->route->delete(Input::get('id'));

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? ucfirst(lang('short.alert.success.delete', lang('route')))
				: ucfirst(lang('short.alert.failure.delete', lang('route')));
		}

		return Redirect::to('admin/routes')
			->with('flashStatus', $flashStatus)
			->with('flashMessage', $flashMessage);
	}

}