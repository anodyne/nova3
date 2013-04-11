<?php namespace Nova\Core\Controller\Base;

use View;
use Session;
use Location;
use BaseController;
use SkinSectionCatalog;

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
		$sectionControllerStartup = function() use(&$me)
		{
			// Set the variables
			$me->skin		= Session::get('skin_login', $me->settings->skin_login);
			$me->rank		= Session::get('rank', $me->settings->rank);
			$me->timezone	= Session::get('timezone', $me->settings->timezone);

			// Get the skin section info
			$me->_sectionInfo = SkinSectionCatalog::getItem($me->skin, 'skin');
		};

		/**
		 * Before filter that creates the template objects.
		 */
		$templateStart = function() use(&$me)
		{
			// Set the values to be passed to the structure
			$vars = array(
				'skin'		=> $me->skin,
				'section'	=> 'login',
				'settings'	=> $me->settings,
			);

			// Set the structure file
			$me->template = View::make(Location::file('login', $me->skin, 'structure'))->with($vars);
			$me->template->layout = View::make(Location::file('login', $me->skin, 'template'))->with($vars);

			// Populate the template
			$me->template->title 			= $me->settings->sim_name.' :: ';
			$me->template->javascript		= false;
			$me->template->layout->ajax 	= false;
			$me->template->layout->flash	= false;
			$me->template->layout->content	= false;
			$me->template->layout->header	= false;
			$me->template->layout->message	= false;
		};

		/**
		 * Call the before filters.
		 */
		try
		{
			$this->beforeFilter($sectionControllerStartup());
			$this->beforeFilter($templateStart());
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
		}
	}

}