<?php namespace Nova\Core\Controllers\Admin;

use Str;
use View;
use Input;
use Location;
use Redirect;
use AdminBaseController;
use SiteContentValidator;
use SystemRouteRepositoryInterface;

class Manage extends AdminBaseController {

	public function __construct(SystemRouteRepositoryInterface $routes)
	{
		parent::__construct();

		$this->routes = $routes;
	}

	public function getSiteContent($id = false)
	{
		// Verify the user is allowed
		$this->currentUser->allowed(['content.create', 'content.update', 'content.delete'], true);

		// Set the views
		$this->_jsView = 'admin/manage/sitecontent_js';

		if ($id !== false)
		{
			// Set the view
			$this->_view = 'admin/manage/sitecontent_action';

			// Get the content item
			$content = $this->_data->content = $this->content->find($id);

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
			$this->_jsData->routeSource = json_encode($routeList);

			// Set the mode and form action
			$this->_mode = $this->_data->action = ($id == 'create') ? 'create' : 'update';
		}
		else
		{
			// Set the view
			$this->_view = 'admin/manage/sitecontent';

			// Get all the site content
			$contents = $this->content->all();

			foreach ($contents as $content)
			{
				// Get the type
				$this->_data->contentTypes[$content->type] = ucfirst(Str::plural($content->type));

				// Get the content
				$this->_data->content[$content->type][] = $content;
			}
		}
	}
	public function postSiteContent()
	{
		// Get the action
		$action = e(Input::get('formAction'));

		// Set up the validation service
		$validator = new SiteContentValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
		{
			return Redirect::back()->withInput()->withErrors($validator->getErrors());
		}

		/**
		 * Create the new site content.
		 */
		if ($this->currentUser->hasAccess('content.create') and $action == 'create')
		{
			// Create the item
			$item = $this->content->create(Input::all());

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? lang('Short.alert.success.create', langConcat('site content'))
				: lang('Short.alert.failure.create', langConcat('site content'));
		}

		/**
		 * Update the site content.
		 */
		if ($this->currentUser->hasAccess('content.update') and $action == 'update')
		{
			// Update the item
			$item = $this->content->update(Input::get('id'), Input::all());

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? lang('Short.alert.success.update', langConcat('site content'))
				: lang('Short.alert.failure.update', langConcat('site content'));
		}

		return Redirect::to('admin/manage/sitecontent')
			->with('flashStatus', $flashStatus)
			->with('flashMessage', $flashMessage);
	}

}