<?php namespace Nova\Foundation\Http\Controllers;

class WelcomeController extends Controller {

	protected $section = 'main';

	public function index()
	{
		$this->view = 'welcome';
	}

}
