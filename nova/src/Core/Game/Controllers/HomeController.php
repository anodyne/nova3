<?php namespace Nova\Core\Game\Controllers;

use BaseController;

class HomeController extends BaseController {

	public function home()
	{
		$this->view = 'home';
	}

}
