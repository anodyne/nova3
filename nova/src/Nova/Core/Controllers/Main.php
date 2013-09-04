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
use SiteContentRepositoryInterface;

class Main extends MainBaseController {

	public function __construct(SiteContentRepositoryInterface $content)
	{
		parent::__construct($content);

		$this->content = $content;

		// Get a copy of the controller
		$me = $this;

		// Do the final nav setup
		$this->beforeFilter(function() use(&$me)
		{
			if ( ! $me->_stopExecution)
			{
				if ($me->_skinInfo->nav == 'classic')
				{
					// Set the type and category
					$me->nav->setType('sub')->setCategory('main');

					// Build the menu
					$me->layout->template->navsub->menu = $me->nav->build();
				}
			}
		});
	}

	public function getIndex()
	{
		// Set the views
		$this->_view = 'main/index';
		$this->_jsView = 'main/index_js';
	}

	public function getCredits()
	{
		// Set the view
		$this->_view = 'main/credits';

		// Get the permanent credits
		$this->_data->permanentCredits = Markdown::parse($this->content->findByKey('other.credits'));
	}

}