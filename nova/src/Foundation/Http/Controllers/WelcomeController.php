<?php namespace Nova\Foundation\Http\Controllers;

class WelcomeController extends Controller {

	public function index()
	{
		$this->view = 'welcome';
	}

}
