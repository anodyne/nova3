<?php namespace Nova\Core\Controllers;

/**
 * Controller that handles requests for the "sim" section of Nova.
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Controllers
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

use MainBaseController;
use SiteContentRepositoryInterface;

class Sim extends MainBaseController {

	public function __construct(SiteContentRepositoryInterface $content)
	{
		parent::__construct($content);

		$this->content = $content;

		// Get a copy of the controller
		$me = $this;

		// Do the final nav setup
		$finalNavSetup = function() use(&$me)
		{
			if ($me->_skinInfo->nav == 'classic')
			{
				// Set the type and category
				$me->nav->setType('sub')->setCategory('sim');

				// Build the menu
				$me->template->layout->navsub->menu = $me->nav->build();
			}
		};

		// Run the before filter
		$this->beforeFilter($finalNavSetup());
	}

	public function getIndex() {}

}