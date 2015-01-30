<?php namespace Nova\Foundation\Http\Controllers;

class WelcomeController extends BaseController {

	public function index()
	{
		$this->view = 'welcome';
	}

}
