<?php namespace Nova\Foundation\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands,
	Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as IlluminateController;

abstract class Controller extends IlluminateController {

	use DispatchesCommands, ValidatesRequests;

	public function __construct()
	{
		// Let's bind some common stuff to every single view
		view()->share('_page', false);
		view()->share('_icons', false);
		view()->share('_currentUser', app('nova.user'));
	}

}
