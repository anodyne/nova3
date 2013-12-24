<?php namespace Nova\Core\Controllers\Admin;

use Str;
use View;
use Event;
use Input;
use Session;
use Location;
use Markdown;
use Redirect;
use AdminBaseController;
use SiteContentValidator;
use SystemRouteValidator;
use RouteProtectedException;
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

		// Set the view
		$this->jsView = 'admin/manage/routes_js';

		if ($routeId !== false)
		{
			// Set the view
			$this->view = 'admin/manage/routes_action';

			// Do some sanity checking on the route ID
			$routeId = (is_numeric($routeId)) ? (int) $routeId : 0;

			// Get the route
			$this->data->route = $this->routes->find($routeId);

			// Set the action
			$this->mode = $this->data->action = ($routeId === 0) ? 'create' : 'update';
		}
		else
		{
			// Set the view
			$this->view = 'admin/manage/routes';

			// Get all the routes for the system
			$this->data->routes = $this->routes->allAsArray();
		}
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
			$this->data->content = $this->content->find($contentId);

			// Get all the routes as JSON
			$this->jsData->routeSource = $this->routes->allAsJson();

			// Set the mode and form action
			$this->mode = $this->data->action = ( ! is_numeric($contentId)) ? 'create' : 'update';
		}
		else
		{
			// Set the view
			$this->view = 'admin/manage/sitecontent';

			// Get the content types
			$this->data->contentTypes = $this->content->getForAdmin('ContentTypes');

			// Get the contents
			$this->data->content = $this->content->getForAdmin('Content');
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

	/**
	 * Needs review
	 */
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

	public function getAjaxDeleteSiteContent($id)
	{
		if ($this->auth->check() and $this->currentUser->hasAccess('content.delete'))
		{
			// Get the content item
			$item = $this->content->find($id);

			if ($item)
			{
				return partial('common/modal_content', [
					'modalHeader'	=> lang('Short.delete', langConcat('Site Content')),
					'modalBody'		=> View::make(Location::ajax('admin/admin/delete_sitecontent'))
										->with('sitecontent', $item),
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

	public function postAjaxGetSiteContent()
	{
		echo $this->content->findByKey(Input::get('key'));
	}

	public function postAjaxUpdateSiteContent()
	{
		if ($this->auth->check() and $this->currentUser->hasAccess('content.update'))
		{
			// Get the POST information
			$key = Input::get('key');
			$value = Input::get('value');

			// Break the key up into an array
			$pieces = explode('_', $key);

			// Flip the array around
			$pieces = array_reverse($pieces);

			// Make sure we don't have any tags in the headers
			$content = ($pieces[0] == 'header') ? strip_tags(Markdown::parse($value)) : $value;

			// Save the content
			$this->content->updateByKey([$key => $content]);

			// If it's a header, show the content, otherwise we need to parse the Markdown
			if ($pieces[0] == 'header')
			{
				echo $content;
			}
			else
			{
				echo Markdown::parse($content);
			}
		}
	}

}