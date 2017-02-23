<?php namespace Nova\Core\Game\Http\Controllers;

use BaseController;

class HomeController extends BaseController {

	public function icons()
	{
		$this->views->put('page', 'icons');
		$this->data->icons = theme()->getIconMap();

		$this->structureData->mdDescription = false;
		$this->structureData->mdTitle = "Icons";
		$this->structureData->pageTitle = "Icons";
	}

}
