<?php namespace Nova\Core\Controller\Admin;

use Sentry;
use AdminBaseController;

class Main extends AdminBaseController {

	public function getIndex()
	{
		dd(Sentry::getUser());
	}

}