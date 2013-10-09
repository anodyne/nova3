<?php namespace Nova\Setup\Controllers\Base;

use App;
use Str;
use File;
use View;
use Cache;
use Route;
use Request;
use Session;
use Location;
use Redirect;
use stdClass;
use ErrorCode;
use Exception;
use Controller;
use NovaAuthInterface;

abstract class Setup extends Controller {

	/**
	 * The application container.
	 */
	protected $app;

	/**
	 * A View object for storing the template.
	 */
	public $template;

	/**
	 * The Request instance.
	 */
	protected $request;

	/**
	 * Name of the view file to use.
	 */
	protected $view;
	
	/**
	 * Controller action data.
	 */
	protected $data;
	
	/**
	 * Name of the JavaScript view file to use.
	 */
	protected $jsView;
	
	/**
	 * Controller action data for the JavaScript view.
	 */
	protected $jsData;

	/**
	 * Page title.
	 */
	protected $title;

	/**
	 * Page header.
	 */
	protected $header;

	/**
	 * Controls for the page.
	 */
	protected $controls = false;

	/**
	 * Steps indicator for the page.
	 */
	protected $steps = false;

	/**
	 * Array of flash messages
	 */
	protected $flash = [];

	/**
	 * Array of ajax views
	 */
	protected $ajax = [];

	/**
	 * Stop execution (used specifically for filters)
	 */
	protected $stopExecution = false;

	/**
	 * The controller used for the current request.
	 */
	protected $controller;

	/**
	 * The action method used for the current request.
	 */
	protected $action;

	/**
	 * The controller used for the current request with namespace.
	 */
	protected $fullController;

	/**
	 * The action method used for the current request with HTTP verb.
	 */
	protected $fullAction;

	public function __construct(NovaAuthInterface $auth)
	{
		$this->auth = $auth;

		// Get the application container
		$this->app = App::make('app');

		// Set the controller and action names
		$this->getControllerName();
		$this->getActionName();

		// Get a copy of the controller
		$me = $this;

		/**
		 * Before closure that checks for the database config file.
		 */
		$this->beforeFilter(function() use (&$me)
		{
			if ( ! File::exists(APPPATH.'config/'.$this->app->environment().'/database.php'))
			{
				// Only redirect if we aren't on the config page(s)
				if ( ! Request::is('setup/config/db*') and ! Request::is('setup'))
				{
					// Stop the execution
					$me->stopExecution = true;

					return Redirect::to('setup');
				}
			}
		});

		/**
		 * Before closure that checks if the user is allowed to be here.
		 */
		$this->beforeFilter(function() use (&$me)
		{
			// Grab the URL generator from the container
			$url = $this->app['url'];

			if ( ! $me->stopExecution)
			{
				if (\Setup::installed(false))
				{
					\Log::info(\Setup::installed(false));
					\Log::info(Cache::get('nova.installed'));
					
					if (Cache::get('nova.installed') !== null)
					{
						if ($me->auth->check())
						{
							// Not a system administrator? No soup for you!
							if ( ! $me->auth->getUser()->isAdmin())
							{
								// Put the intended desintation into the session
								Session::put('url.intended', $url->full());

								return Redirect::to('login/error/'.ErrorCode::LOGIN_NOT_ADMIN);
							}
						}
						else
						{
							// Put the intended desintation into the session
							Session::put('url.intended', $url->full());

							// No session? Send them away
							return Redirect::to('login/error/'.ErrorCode::LOGIN_NOT_LOGGED_IN);
						}
					}
				}
			}
		});

		/**
		 * Before closure that handles the setup of each request.
		 */
		$this->beforeFilter(function() use (&$me)
		{
			if ( ! $me->stopExecution)
			{
				// Set the Request instance
				$me->request = Request::instance();

				// Create empty objects for the data
				$me->data = new stdClass;
				$me->jsData = new stdClass;
			}
		});
	}

	/**
	 * Finalize the layout.
	 *
	 * @return	void
	 */
	protected function finalizeLayout()
	{
		if ( ! is_object($this->layout)) return;

		// Set the view (if it's been set)
		if ( ! empty($this->view))
		{
			$this->layout->template->content = View::make(Location::page($this->view))
				->with((array) $this->data);
		}
		
		// Set the javascript view (if it's been set)
		if ( ! empty($this->jsView))
		{
			$this->layout->javascript = View::make(Location::js($this->jsView))
				->with((array) $this->jsData);
		}

		// Steps indicator
		if ( ! empty($this->steps))
		{
			$this->layout->template->steps = View::make(Location::partial($this->steps));
		}

		// Build the controls
		$this->layout->template->controls = $this->controls;

		// Set the title
		$this->layout->title = $this->title;

		// Set the header
		$this->layout->template->header = $this->header;

		// If there's flash data in the session, grab it
		if (Session::has('flashStatus'))
		{
			$this->flash[] = [
				'class'		=> 'alert-'.Session::get('flashStatus'),
				'content'	=> Session::get('flashMessage'),
			];
		}
		
		// Flash messages
		if (count($this->flash) > 0)
		{
			foreach ($this->flash as $flash)
			{
				$this->layout->template->flash.= partial('common/alert', $flash);
			}
		}

		// Ajax views
		if (count($this->ajax) > 0)
		{
			foreach ($this->ajax as $ajax)
			{
				$this->layout->template->ajax.= $ajax;
			}
		}
	}

	/**
	 * Setup the layout.
	 *
	 * @return	void
	 */
	protected function setupLayout()
	{
		if ( ! $this->stopExecution)
		{
			// Setup the layout and its data
			$layout				= View::make(Location::structure('setup'));
			$layout->title		= false;
			$layout->javascript	= false;
			
			// Setup the template and its data
			$layout->template			= View::make(Location::template('setup'));
			$layout->template->ajax		= false;
			$layout->template->flash	= false;
			$layout->template->content	= false;
			$layout->template->header	= false;
			$layout->template->controls	= false;
			$layout->template->steps	= false;

			// Pass everything back to the layout
			$this->layout = $layout;
		}
	}

	/**
	 * Process a controller action response.
	 *
	 * This overrides the Laravel default controller functionality so
	 * we can finalize the layout before its sent to the response.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @param  string  $method
	 * @param  mixed   $response
	 * @return Symfony\Component\HttpFoundation\Response
	 */
	protected function processResponse($router, $method, $response)
	{
		$this->finalizeLayout();

		return parent::processResponse($router, $method, $response);
	}

	/**
	 * Make sure the action name is setup properly.
	 *
	 * @return	string
	 */
	protected function getActionName()
	{
		// Set the fully qualified action name
		$this->fullAction = $actionName = Str::parseCallback(Route::currentRouteAction(), false)[1];

		// Remove the HTTP verb
		$actionName = (substr($actionName, 0, 3) == 'get') ? substr_replace($actionName, '', 0, 3) : $actionName;
		$actionName = (substr($actionName, 0, 3) == 'put') ? substr_replace($actionName, '', 0, 3) : $actionName;
		$actionName = (substr($actionName, 0, 4) == 'post') ? substr_replace($actionName, '', 0, 4) : $actionName;
		$actionName = (substr($actionName, 0, 6) == 'delete') ? substr_replace($actionName, '', 0, 6) : $actionName;

		// Set the short action name
		$this->action = Str::lower($actionName);
	}

	protected function getControllerName()
	{
		// Set the namespaced controller name
		$this->fullController = Str::parseCallback(Route::currentRouteAction(), false)[0];

		// Set the controller name
		$this->controller = Str::denamespace($this->fullController);
	}

}