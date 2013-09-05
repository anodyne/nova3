<?php namespace Nova\Core\Controllers\Base;

use View;
use Session;
use Location;
use BaseController;
use SiteContentRepositoryInterface;

abstract class Login extends BaseController {

	public function __construct(SiteContentRepositoryInterface $content)
	{
		parent::__construct($content);

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

			// Resolve the catalog interface
			$catalog = $me->resolveBinding('CatalogRepositoryInterface');

			// Get the skin section info
			$me->_skinInfo	= $catalog->findSkinByLocation($me->skin);
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
			'skinInfo'	=> $this->_skinInfo,
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