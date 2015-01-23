<?php namespace Nova\Setup\Http\Controllers;

use stdClass;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController {

	public function __construct()
	{
		// Make sure the setup module is in the views path
		view()->addLocation(app_path('Setup/views'));
		
		// Make sure every view has access to the setup icons list
		view()->share('_icons', config('icons.setup'));
	}

}