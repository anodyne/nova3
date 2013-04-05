<?php namespace Nova\Core\Controller;

/**
 * Controller that handles requests for the "main" section of Nova.
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

use Form;
use MainBaseController;

class Main extends MainBaseController {

	public function __construct()
	{
		parent::__construct();

		// Get a copy of the controller
		$me = $this;

		// Do the final nav setup
		$finalNavSetup = function() use(&$me)
		{
			if ($me->_sectionInfo->nav == 'classic')
			{
				// Set the type and category
				$me->nav->setType('sub')->setCategory('main');

				// Build the menu
				$me->template->layout->navsub->menu = $me->nav->build();
			}
		};

		// Run the before filter
		$this->beforeFilter($finalNavSetup());
	}

	public function getIndex()
	{
		$output = Form::open(array('method' => 'delete'));
		$output.= Form::button('Submit', array(
			'type' => 'submit',
			'class' => 'btn btn-primary',
		));
		$output.= Form::close();

		return $output;
	}
	public function postIndex()
	{
		$output = Form::open(array('method' => 'delete'));
		$output.= Form::button('Submit', array(
			'type' => 'submit',
			'class' => 'btn btn-primary',
		));
		$output.= Form::close();

		return $output;
	}
	public function putIndex()
	{
		$output = Form::open(array('method' => 'delete'));
		$output.= Form::button('Submit', array(
			'type' => 'submit',
			'class' => 'btn btn-primary',
		));
		$output.= Form::close();

		return $output;
	}

}