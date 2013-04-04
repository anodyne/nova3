<?php namespace Nova\Core\Controller;

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

	public function actionIndex() {}

}