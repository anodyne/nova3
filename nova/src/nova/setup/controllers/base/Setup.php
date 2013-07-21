<?php namespace Nova\Setup\Controllers\Base;

use App;
use Str;
use File;
use View;
use Cache;
use Route;
use Sentry;
use Request;
use Session;
use Location;
use Redirect;
use stdClass;
use Exception;
use Controller;

abstract class Setup extends Controller {

	/**
	 * A View object for storing the template.
	 */
	public $template;

	/**
	 * The Request instance.
	 */
	public $request;

	/**
	 * Name of the view file to use.
	 */
	public $_view;
	
	/**
	 * Controller action data.
	 */
	public $_data;
	
	/**
	 * Name of the JavaScript view file to use.
	 */
	public $_jsView;
	
	/**
	 * Controller action data for the JavaScript view.
	 */
	public $_jsData;

	/**
	 * Page title.
	 */
	public $_title;

	/**
	 * Page header.
	 */
	public $_header;

	/**
	 * Controls for the page.
	 */
	public $_controls = false;

	/**
	 * Steps indicator for the page.
	 */
	public $_steps = false;

	/**
	 * Array of flash messages
	 */
	public $_flash = [];

	/**
	 * Array of ajax views
	 */
	public $_ajax = [];

	/**
	 * Stop execution (used specifically for filters)
	 */
	protected $_stopExecution = false;

	/**
	 * The controller used for the current request.
	 */
	public $_controller;

	/**
	 * The action method used for the current request.
	 */
	public $_action;

	/**
	 * The controller used for the current request with namespace.
	 */
	public $_fullController;

	/**
	 * The action method used for the current request with HTTP verb.
	 */
	public $_fullAction;

	public function __construct()
	{
		// Set the controller and action names
		$this->getControllerName();
		$this->getActionName();

		// Add the setup package to the list for this request
		View::addLocation(SRCPATH.'setup/views');

		// Get a copy of the controller
		$me = $this;

		/**
		 * Before closure that checks for the database config file.
		 */
		$this->beforeFilter(function() use(&$me)
		{
			if ( ! File::exists(APPPATH.'config/'.App::environment().'/database.php'))
			{
				// Only redirect if we aren't on the config page(s)
				if ( ! Request::is('setup/config/db*') and ! Request::is('setup'))
				{
					// Stop the execution
					$me->_stopExecution = true;

					return Redirect::to('setup');
				}
			}
		});

		/**
		 * Before closure that checks if the user is allowed to be here.
		 */
		$this->beforeFilter(function() use(&$me)
		{
			if ( ! $me->_stopExecution)
			{
				if (\Setup::installed())
				{
					if (Sentry::check())
					{
						// Not a system administrator? No soup for you!
						if ( ! Sentry::getUser()->isAdmin())
						{
							//return Redirect::to('login/'.Nova\Core\Controllers\Login::NOT_ADMIN);
						}
					}
					else
					{
						// No session? Send them away
						//return Redirect::to('login/'.Nova\Core\Controllers\Login::NOT_LOGGED_IN);
					}
				}
			}
		});

		/**
		 * Before closure that handles the setup of each request.
		 */
		$this->beforeFilter(function() use(&$me)
		{
			if ( ! $me->_stopExecution)
			{
				// Set the Request instance
				$me->request = Request::instance();

				// Create empty objects for the data
				$me->_data = new stdClass;
				$me->_jsData = new stdClass;
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

		// Calculate the content view if it isn't set
		$this->_view = (empty($this->_view)) 
			? Str::lower($this->_controller).'/'.Str::lower($this->_action) 
			: $this->_view;
		
		// Set the content view
		$this->layout->template->content = View::make(Location::page($this->_view))
			->with((array) $this->_data);
		
		// Set the javascript view (if it's been set)
		if ( ! empty($this->_jsView))
		{
			$this->layout->javascript = View::make(Location::js($this->_jsView))
				->with((array) $this->_jsData);
		}

		// Steps indicator
		if ( ! empty($this->_steps))
		{
			$this->layout->template->steps = View::make(Location::partial($this->_steps));
		}

		// Build the controls
		$this->layout->template->controls = $this->_controls;

		// Set the title
		$this->layout->title = $this->_title;

		// Set the header
		$this->layout->template->header = $this->_header;

		// If there's flash data in the session, grab it
		if (Session::has('flashStatus'))
		{
			$this->_flash[] = [
				'class'		=> 'alert-'.Session::get('flashStatus'),
				'content'	=> Session::get('flashMessage'),
			];
		}
		
		// Flash messages
		if (count($this->_flash) > 0)
		{
			foreach ($this->_flash as $flash)
			{
				$this->layout->template->flash.= partial('common/alert', $flash);
			}
		}

		// Ajax views
		if (count($this->_ajax) > 0)
		{
			foreach ($this->_ajax as $ajax)
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
		if ( ! $this->_stopExecution)
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
		$this->_fullAction = $actionName = Str::parseCallback(Route::currentRouteAction(), false)[1];

		// Remove the HTTP verb
		$actionName = (substr($actionName, 0, 3) == 'get') ? substr_replace($actionName, '', 0, 3) : $actionName;
		$actionName = (substr($actionName, 0, 3) == 'put') ? substr_replace($actionName, '', 0, 3) : $actionName;
		$actionName = (substr($actionName, 0, 4) == 'post') ? substr_replace($actionName, '', 0, 4) : $actionName;
		$actionName = (substr($actionName, 0, 6) == 'delete') ? substr_replace($actionName, '', 0, 6) : $actionName;

		// Set the short action name
		$this->_action = Str::lower($actionName);
	}

	protected function getControllerName()
	{
		// Set the namespaced controller name
		$this->_fullController = Str::parseCallback(Route::currentRouteAction(), false)[0];

		// Set the controller name
		$this->_controller = Str::denamespace($this->_fullController);
	}

}