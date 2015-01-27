<?php namespace Nova\Setup\Http\Controllers;

use stdClass;
use Redirect;
use Illuminate\Database\QueryException;

class SetupController extends Controller {

	public function index()
	{
		/*if (app('nova.setup')->isInstalled())
		{
			return Redirect::route('setup.update');
		}*/

		return view('pages.setup.index');
	}

}
