<?php namespace Nova\Foundation\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands,
	Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as IlluminateController;

abstract class Controller extends IlluminateController {

	use DispatchesCommands, ValidatesRequests;

	public function __construct()
	{
		// Check if Nova is installed
		$this->middleware('nova.installed');

		// Bind the data we need to all views
		$this->middleware('nova.bindViewData');
	}

}
