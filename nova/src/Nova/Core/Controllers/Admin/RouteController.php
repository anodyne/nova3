<?php namespace Nova\Core\Controllers\Admin;

use View,
	Event,
	Input,
	Session,
	Location,
	Redirect,
	AdminBaseController,
	SystemRouteValidator,
	RouteProtectedException,
	SystemRouteRepositoryInterface;

class ManageController extends AdminBaseController {

	protected $routes;

	public function __construct(SystemRouteRepositoryInterface $routes)
	{
		parent::__construct();

		// Set the injected interfaces
		$this->routes = $routes;
	}

	public function index()
	{
		// Verify the user is allowed
		$this->currentUser->allowed(['routes.create', 'routes.update', 'routes.delete'], true);

		// Set the views
		$this->jsView = 'admin/manage/routes_js';
		$this->view = 'admin/manage/routes/index';

		// Get all the routes for the system
		$this->data->routes = $this->routes->allAsArray();
	}

	public function create()
	{
		// Verify the user is allowed
		$this->currentUser->allowed('routes.create', true);

		// Set the views
		$this->jsView = 'admin/manage/routes_js';
		$this->view = 'admin/manage/routes_action';

		// Get the route
		$this->data->route = false;

		// Set the action
		$this->mode = $this->data->action = 'create';
	}

	public function store()
	{
		// Set up the validation service
		$validator = new SystemRouteValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
		{
			return Redirect::back()->withInput()->withErrors($validator->getErrors());
		}

		if ($this->currentUser->hasAccess('routes.create'))
		{
			if (Input::get('formAction') == 'create')
			{
				$item = $this->routes->create(Input::all());

				Event::fire('nova.route.created', [$item, Input::all()]);
			}

			if (Input::get('formAction') == 'duplicate')
			{
				$item = $this->routes->duplicate(Input::get('id'));

				Event::fire('nova.route.duplicated', [$item, Input::all()]);
			}
		}

		return Redirect::to('admin/routes');
	}

	public function edit($id)
	{
		// Verify the user is allowed
		$this->currentUser->allowed('routes.update', true);

		// Set the views
		$this->jsView = 'admin/manage/routes_js';
		$this->view = 'admin/manage/routes_action';

		// Get the route
		$this->data->route = $this->routes->find($id);

		// Set the action
		$this->mode = $this->data->action = 'update';
	}

	public function update($id)
	{
		// Get the form action
		$formAction = Input::get('formAction');

		// Set up the validation service
		$validator = new SystemRouteValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
		{
			return Redirect::back()->withInput()->withErrors($validator->getErrors());
		}

		// Create a new route
		if ($this->currentUser->hasAccess('routes.create') and $formAction == 'create')
		{
			$item = $this->routes->create(Input::all());

			Event::fire('nova.route.created', [$item, Input::all()]);
		}

		// Duplicate a core route
		if ($this->currentUser->hasAccess('routes.create') and $formAction == 'duplicate')
		{
			$item = $this->routes->duplicate(Input::get('id'));

			Event::fire('nova.route.duplicated', [$item, Input::all()]);
		}

		// Update a route
		if ($this->currentUser->hasAccess('routes.update') and $formAction == 'update')
		{
			$item = $this->routes->update(Input::get('id'), Input::all());

			Event::fire('nova.route.updated', [$item, Input::all()]);
		}

		// Delete a route
		if ($this->currentUser->hasAccess('routes.delete') and $formAction == 'delete')
		{
			try
			{
				$item = $this->routes->delete(Input::get('id'));

				Event::fire('nova.route.deleted', [$item, Input::all()]);
			}
			catch (RouteProtectedException $e)
			{
				Session::flash('flashStatus', 'danger');
				Session::flash('flashMessage', lang('error.admin.route.protected'));
			}
		}

		return Redirect::to('admin/routes');
	}

	public function destroy($id)
	{
		# code...
	}

	public function postRoutes()
	{
		// Get the form action
		$formAction = Input::get('formAction');

		// Set up the validation service
		$validator = new SystemRouteValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
		{
			return Redirect::back()->withInput()->withErrors($validator->getErrors());
		}

		// Create a new route
		if ($this->currentUser->hasAccess('routes.create') and $formAction == 'create')
		{
			$item = $this->routes->create(Input::all());

			Event::fire('nova.route.created', [$item, Input::all()]);
		}

		// Duplicate a core route
		if ($this->currentUser->hasAccess('routes.create') and $formAction == 'duplicate')
		{
			$item = $this->routes->duplicate(Input::get('id'));

			Event::fire('nova.route.duplicated', [$item, Input::all()]);
		}

		// Update a route
		if ($this->currentUser->hasAccess('routes.update') and $formAction == 'update')
		{
			$item = $this->routes->update(Input::get('id'), Input::all());

			Event::fire('nova.route.updated', [$item, Input::all()]);
		}

		// Delete a route
		if ($this->currentUser->hasAccess('routes.delete') and $formAction == 'delete')
		{
			try
			{
				$item = $this->routes->delete(Input::get('id'));

				Event::fire('nova.route.deleted', [$item, Input::all()]);
			}
			catch (RouteProtectedException $e)
			{
				Session::flash('flashStatus', 'danger');
				Session::flash('flashMessage', lang('error.admin.route.protected'));
			}
		}

		return Redirect::to('admin/routes');
	}

	public function getAjaxDeleteRoute($id)
	{
		if ($this->auth->check() and $this->currentUser->hasAccess('routes.delete'))
		{
			// Get the route
			$route = $this->routes->find($id);

			if ($route)
			{
				// Do we have any other similar routes?
				$similarRoutes = $this->routes->findByUri($route->uri, $route->verb, true);

				return partial('common/modal_content', [
					'modalHeader'	=> lang('Short.delete', lang('Route')),
					'modalBody'		=> View::make(Location::ajax('admin/admin/delete_route'))
										->with('route', $route)
										->with('similarRoutes', $similarRoutes > 1),
					'modalFooter'	=> false,
				]);
			}
		}
	}

	public function getAjaxDuplicateRoute($id)
	{
		if ($this->auth->check() and $this->currentUser->hasAccess('routes.create'))
		{
			// Get the original route
			$route = $this->routes->find($id);

			if ($route)
			{
				return partial('common/modal_content', [
					'modalHeader'	=> lang('Short.duplicate', langConcat('Core Route')),
					'modalBody'		=> View::make(Location::ajax('admin/admin/duplicate_route'))
										->with('route', $route),
					'modalFooter'	=> false,
				]);
			}
		}
	}

}