<?php
/**
 * Nova's main base controller.
 *
 * This file is aliased to the class name `MainBaseController`.
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Nova\Core\Controller\Base;

abstract class Main extends \BaseController {

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
			$me->skin		= \Session::get('skin_main', $me->settings->skin_main);
			$me->rank		= \Session::get('rank', $me->settings->rank);
			$me->timezone	= \Session::get('timezone', $me->settings->timezone);
			$me->images		= \Utility::getImageIndex($me->skin);

			// Get the skin section info
			$me->_sectionInfo = \SkinSectionCatalog::getItem($me->skin, 'skin');
		};

		/**
		 * Before filter that creates the template objects.
		 */
		$templateStart = function() use(&$me)
		{
			// Resolve an instance of the Location class from the App container
			$loc = \App::make('location');

			// Set the values to be passed to the structure
			$vars = array(
				'skin'		=> $me->skin,
				'sec'		=> 'main',
				'settings'	=> $me->settings,
			);

			// Set the structure file
			$me->template = \View::make($loc->file('main', $me->skin, 'structure'), $vars);
			$me->template->layout = \View::make($loc->file('main', $me->skin, 'template'), $vars);
			//$me->template->layout->navsub = \View::make($loc->file('navsub', $me->skin, 'partial'));
			$me->template->layout->footer = \View::make($loc->file('footer', $me->skin, 'partial'));
		};

		/**
		 * Before filter that fills the template with default data.
		 */
		$templateFill = function() use(&$me)
		{
			// Build the navigation
			$me->nav->setStyle($me->_sectionInfo->nav)
				->setSection('main')
				->setCategory('main')
				->setType('main');
			
			// Populate the template
			$me->template->title 					= $me->settings->sim_name.' :: ';
			$me->template->javascript				= false;
			$me->template->layout->ajax 			= false;
			$me->template->layout->flash			= false;
			$me->template->layout->content			= false;
			$me->template->layout->header			= false;
			$me->template->layout->message			= false;
			$me->template->layout->navmain 			= $me->nav->build();
			/*$me->template->layout->navsub->menu		= false;
			$me->template->layout->navsub->widget1	= false;
			$me->template->layout->navsub->widget2	= false;
			$me->template->layout->navsub->widget3	= false;*/
			$me->template->layout->footer->extra 	= \SiteContent::getContentItem('footer');
		};

		// Call the before filters
		try
		{
			$this->beforeFilter($sectionControllerStartup());
			$this->beforeFilter($templateStart());
			$this->beforeFilter($templateFill());
		}
		catch (\Exception $e)
		{
			echo $e->getMessage();		
		}
	}
}
