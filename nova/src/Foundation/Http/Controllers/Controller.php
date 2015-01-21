<?php namespace Nova\Foundation\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands,
	Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as IlluminateController;

abstract class Controller extends IlluminateController {

	use DispatchesCommands, ValidatesRequests;

	protected $app;

	public function __construct()
	{
		// Grab the application
		$this->app = app();

		// Let's bind some common stuff to every single view
		view()->share('_page', app('PageRepository')->getByRoute($this->app['request']->route()));
		view()->share('_icons', false);
		view()->share('_currentUser', app('nova.user'));
	}

}
