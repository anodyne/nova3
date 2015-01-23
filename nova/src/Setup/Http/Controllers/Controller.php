<?php namespace Nova\Setup\Http\Controllers;

use stdClass;
use Request;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController {

	protected $setupType;

	public function __construct()
	{
		// Store the setup type on the controller
		$this->setupType = Request::segment(2);

		// Share the setup type with every view that's created
		view()->share('_setupType', $this->setupType);

		// Make sure the setup module is in the views path
		view()->addLocation(app_path('Setup/views'));
		
		// Make sure every view has access to the setup icons list
		view()->share('_icons', config('icons.setup'));
	}

}