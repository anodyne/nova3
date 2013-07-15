<?php namespace Nova\Core\Controllers\Admin;

use View;
use Input;
use Sentry;
use Location;
use Redirect;
use AdminBaseController;

class Catalog extends AdminBaseController {

	public function getIndex()
	{
		$this->_view = 'admin/catalog/catalogs';
	}

	public function getModules()
	{
		# code...
	}
	public function postModules()
	{
		# code...
	}

	public function getRanks()
	{
		$this->_view = 'admin/catalog/ranks';
	}
	public function postRanks()
	{
		# code...
	}

	public function getSkins()
	{
		# code...
	}
	public function postSkins()
	{
		# code...
	}

	public function getWidgets()
	{
		# code...
	}
	public function postWidgets()
	{
		# code...
	}

}