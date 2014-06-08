<?php namespace Nova\Core\Controllers;

/**
 * Controller that handles requests for the "main" section of Nova.
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Controllers
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

use Markdown;
use MainBaseController;

class MainController extends MainBaseController {

	public function __construct()
	{
		parent::__construct();

		// Get a copy of the controller
		$me = $this;

		// Do the final nav setup
		$this->beforeFilter(function() use (&$me)
		{
			if ( ! $me->stopExecution)
			{
				if ($me->skinInfo->nav == 'classic')
				{
					// Set the type and category
					$me->nav->setType('sub')->setCategory('main');

					// Build the menu
					$me->layout->template->navsub->menu = $me->nav->build();
				}
			}
		});
	}

	public function index()
	{
		// Set the views
		$this->view = 'main/index';
		$this->jsView = 'main/index_js';
	}

	public function credits()
	{
		// Set the view
		$this->view = 'main/credits';

		// Get the permanent credits
		$this->data->permanentCredits = Markdown::parse($this->content->findByKey('other.credits'));
	}

}