<?php namespace Nova\Core\Controllers\Base;

use View;
use Session;
use Location;
use SkinCatalog;
use BaseController;

abstract class Login extends BaseController {

	/**
	 * Log In Error Codes
	 */
	const OK 				= 0;
	const NOT_LOGGED_IN 	= 1;
	const NO_EMAIL 			= 2;
	const NO_PASSWORD		= 3;
	const NOT_FOUND			= 4;
	const SUSPENDED			= 5;
	const BANNED			= 6;

	public function __construct()
	{
		parent::__construct();

		// Get a copy of the controller
		$me = $this;

		/**
		 * Before filter that populates some of the variables with data.
		 */
		$this->beforeFilter(function() use(&$me)
		{
			// Set the variables
			$me->skin		= Session::get('skin_login', $me->settings->skin_login);
			$me->rank		= Session::get('rank', $me->settings->rank);
			$me->timezone	= Session::get('timezone', $me->settings->timezone);

			// Get the skin section info
			$me->_skinInfo	= SkinCatalog::getItems('location', $me->skin)->first();
		});
	}

	/**
	 * Setup the layout.
	 *
	 * @return	void
	 */
	protected function setupLayout()
	{
		// Set the values to be passed to the structure
		$vars = [
			'skin'		=> $this->skin,
			'section'	=> 'login',
			'settings'	=> $this->settings,
		];

		// Setup the layout and its data
		$layout				= View::make(Location::structure('login'))->with($vars);
		$layout->title		= $this->settings->sim_name.' :: ';
		$layout->javascript	= false;
		
		// Setup the template and its data
		$layout->template			= View::make(Location::template('login'))->with($vars);
		$layout->template->ajax		= false;
		$layout->template->flash	= false;
		$layout->template->content	= false;
		$layout->template->header	= false;
		$layout->template->message	= false;

		// Pass everything back to the layout
		$this->layout = $layout;
	}

}