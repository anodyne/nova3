<?php namespace Nova\Setup\Http\Controllers;

use Redirect;

class InstallController extends Controller {

	public function index()
	{
		return view('pages.setup.install');
	}

}
