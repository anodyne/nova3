<?php namespace Nova\Core\Controllers\Admin;

use Str;
use Input;
use Redirect;
use AdminBaseController;
use SiteContentValidator;
use SystemRouteValidator;
use NavigationRepositoryInterface;
use SystemRouteRepositoryInterface;

class Manage extends AdminBaseController {

	public function __construct(SystemRouteRepositoryInterface $routes,
			NavigationRepositoryInterface $navigation)
	{
		parent::__construct();

		// Set the injected interfaces
		$this->routes = $routes;
		$this->navigation = $navigation;
	}

	public function getRoutes($routeId = false)
	{
		// Verify the user is allowed
		$this->currentUser->allowed(['routes.create', 'routes.update', 'routes.delete'], true);

		$this->jsView = 'admin/manage/routes_js';

		if ($routeId !== false)
		{
			$this->view = 'admin/manage/routes_action';

			// Set the ID
			$routeId = (is_numeric($routeId)) ? $routeId : 0;

			// Get the route
			$this->data->route = $this->routes->find($routeId);

			// Set the action
			$this->mode = $this->data->action = ((int) $routeId === 0) ? 'create' : 'update';
		}
		else
		{
			$this->view = 'admin/manage/routes';

			// Get all the routes for the system
			$this->data->routes = $this->routes->all();

			// Build the duplicate page modal
			$this->ajax[] = modal([
				'id'		=> 'duplicateRoute',
				'header'	=> lang('Short.duplicate', langConcat('Core Route'))
			]);

			// Build the delete page modal
			$this->ajax[] = modal([
				'id'		=> 'deleteRoute',
				'header'	=> lang('Short.delete', lang('Route'))
			]);
		}
	}
	public function postRoutes()
	{
		// Get the action
		$formAction = Input::get('formAction');

		// Set up the validation service
		$validator = new SystemRouteValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
		{
			if ($formAction == 'delete' or $formAction == 'duplicate')
			{
				// Set the flash message
				$flashMessage = lang('Short.validate', lang('action.failed')).'. ';
				$flashMessage.= implode(' ', $validator->getErrors()->all());

				return Redirect::to('admin/routes')
					->with('flashStatus', 'danger')
					->with('flashMessage', $flashMessage);
			}

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
			$item = $this->routes->delete(Input::get('id'));

			Event::fire('nova.route.deleted', [$item, Input::all()]);
		}

		return Redirect::to('admin/routes');
	}

	public function getSiteContent($contentId = false)
	{
		// Verify the user is allowed
		$this->currentUser->allowed(['content.create', 'content.update', 'content.delete'], true);

		// Set the views
		$this->jsView = 'admin/manage/sitecontent_js';

		if ($contentId !== false)
		{
			// Set the view
			$this->view = 'admin/manage/sitecontent_action';

			// Get the content item
			$content = $this->data->content = $this->content->find($contentId);

			// Get all the routes
			$routes = $this->routes->all();

			// Start the route source list
			$routeList = [];

			foreach ($routes as $route)
			{
				if ((array_key_exists($route->name, $routeList) and ! (bool) $route->protected)
						or ! array_key_exists($route->name, $routeList))
				{
					$routeList[$route->name] = $route->name;
				}
			}

			// Pass the final route list over to the JS view
			$this->jsData->routeSource = json_encode($routeList);

			// Set the mode and form action
			$this->mode = $this->data->action = ($id == 'create') ? 'create' : 'update';
		}
		else
		{
			// Set the view
			$this->view = 'admin/manage/sitecontent';

			// Get all the site content
			$contents = $this->content->all();

			foreach ($contents as $content)
			{
				// Get the type
				$this->data->contentTypes[$content->type] = ucfirst(Str::plural($content->type));

				// Get the content
				$this->data->content[$content->type][] = $content;
			}

			// Build the delete content modal
			$this->ajax[] = modal([
				'id'		=> 'deleteSiteContent',
				'header'	=> lang('Short.delete', langConcat('Site Content'))
			]);
		}
	}
	public function postSiteContent()
	{
		// Get the action
		$formAction = Input::get('formAction');

		// Set up the validation service
		$validator = new SiteContentValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
		{
			return Redirect::back()->withInput()->withErrors($validator->getErrors());
		}

		// Create the new site content
		if ($this->currentUser->hasAccess('content.create') and $formAction == 'create')
		{
			$item = $this->content->create(Input::all());

			Event::fire('nova.sitecontent.created', [$item, Input::all()]);
		}

		// Update the site content
		if ($this->currentUser->hasAccess('content.update') and $formAction == 'update')
		{
			$item = $this->content->update(Input::get('id'), Input::all());

			Event::fire('nova.sitecontent.updated', [$item, Input::all()]);
		}

		// Delete the site content
		if ($this->currentUser->hasAccess('content.delete') and $formAction == 'delete')
		{
			$item = $this->content->delete(Input::get('id'));

			Event::fire('nova.sitecontent.deleted', [$item, Input::all()]);
		}

		return Redirect::to('admin/sitecontent');
	}

	public function getSiteNavigation($navId = false)
	{
		// Verify the user is allowed
		$this->currentUser->allowed(['nav.create', 'nav.update', 'nav.delete'], true);

		// Set the views
		$this->jsView = 'admin/manage/navigation_js';

		if ($navId !== false)
		{
			// Set the view
			$this->view = 'admin/manage/navigation_action';

			// Get the navigation item
			$this->data->nav = $this->navigation->find($navId);

			// Set the mode and form action
			$this->mode = $this->data->action = ($id == 'create') ? 'create' : 'update';
		}
		else
		{
			// Set the view
			$this->view = 'admin/manage/navigation';

			// Get all the navigation items
			$this->data->items = $this->navigation->all();

			// Get the navigation types
			$this->data->navTypes['main'] = langConcat('Site Navigation');
			$this->data->navTypes['sub'] = ucwords(langConcat('Site Navigation_sub'));
			$this->data->navTypes['admin'] = langConcat('Admin Navigation');
			$this->data->navTypes['adminsub'] = ucwords(langConcat('Admin Navigation_sub'));

			// Get everything!
			$allNavs = $this->navigation->allByTypeAndCategory();

			// Set the navigation content
			$this->data->nav['main'] = $this->navigation->allByType('main');
			$this->data->nav['admin'] = $this->navigation->allByType('admin');
			$this->data->nav['sub'] = $allNavs['sub'];
			$this->data->nav['adminsub'] = $allNavs['adminsub'];

			// Build the delete content modal
			$this->ajax[] = modal([
				'id'		=> 'deleteSiteNavigation',
				'header'	=> lang('Short.delete', langConcat('Site Navigation Item'))
			]);
		}
	}
	public function postSiteNavigation()
	{
		// Get the action
		$formAction = Input::get('formAction');

		// Set up the validation service
		$validator = new NavigationValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
		{
			return Redirect::back()->withInput()->withErrors($validator->getErrors());
		}

		// Create the nav item
		if ($this->currentUser->hasAccess('nav.create') and $formAction == 'create')
		{
			$nav = $this->navigation->create(Input::all());

			Event::fire('nova.nav.created', [$nav, Input::all()]);
		}

		// Duplicate the nav item
		if ($this->currentUser->hasAccess('nav.create') and $formAction == 'duplicate')
		{
			$nav = $this->navigation->duplicate(Input::get('id'), Input::get('name'));

			Event::fire('nova.nav.duplicated', [$nav, Input::all()]);
		}

		// Update the nav item
		if ($this->currentUser->hasAccess('nav.update') and $formAction == 'update')
		{
			$nav = $this->navigation->update(Input::get('id'), Input::all());

			Event::fire('nova.nav.updated', [$nav, Input::all()]);
		}

		// Delete the nav item
		if ($this->currentUser->hasAccess('nav.delete') and $formAction == 'delete')
		{
			$nav = $this->navigation->delete(Input::get('id'));

			Event::fire('nova.nav.deleted', [$nav, Input::all()]);
		}

		return Redirect::to('admin/navigation');
	}

}