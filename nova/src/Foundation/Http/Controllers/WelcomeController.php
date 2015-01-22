<?php namespace Nova\Foundation\Http\Controllers;

class WelcomeController extends Controller {

	public function index()
	{
		return view('nova.views.components.pages.welcome');
	}

}
