<?php namespace Nova\Foundation\Http\Controllers;

use Locate;

class WelcomeController extends Controller {

	public function index()
	{
		return view(Locate::page('welcome'));
	}

}
