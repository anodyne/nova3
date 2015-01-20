<?php namespace Nova\Setup\Http\Controllers;

use stdClass;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController {

	protected $data;

	public function __construct()
	{
		view()->addLocation(app_path('Setup/views'));

		$this->data = new stdClass;
	}

}