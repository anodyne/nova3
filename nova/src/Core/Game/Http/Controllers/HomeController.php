<?php namespace Nova\Core\Game\Http\Controllers;

use BaseController;

class HomeController extends BaseController {

	public function icons()
	{
		$this->view = 'icons';
		$this->data->icons = theme()->getIconMap();

		$this->structureData->pageDescription = false;
		$this->structureData->pageName = "Icons";
		$this->structureData->pageTitle = "Icons";
	}

}
