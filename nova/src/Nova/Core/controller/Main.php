<?php
/**
 * Nova's main controller.
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Nova\Core\Controller;

class Main extends \MainBaseController {

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
				$me->template->layout->navsub->classic = $me->nav->setType('sub')->build();
			}
		};

		// Run the before filter
		$this->beforeFilter($finalNavSetup());
	}

	public function actionIndex()
	{}

	public function actionFoo()
	{
		$this->_data->title = 'Foo';
		$this->_data->header = 'Foo';
		$this->_data->message = 'Foo';
	}
}
