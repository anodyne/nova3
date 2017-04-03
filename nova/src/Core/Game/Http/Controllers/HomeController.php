<?php namespace Nova\Core\Game\Http\Controllers;

use Nova\Foundation\Http\Controllers\NovaController;

class HomeController extends NovaController
{
	public function icons()
	{
		$this->views->put('page', 'icons');
		$this->data->icons = theme()->getIconMap();

		$this->structureData->mdDescription = false;
		$this->structureData->mdTitle = "Icons";
		$this->structureData->pageTitle = "Icons";
	}

	public function test()
	{
		$this->views->put('page', 'test');

		$this->structureData->mdDescription = false;
		$this->structureData->mdTitle = "Data Table";
		$this->structureData->pageTitle = "Data Table";
	}
}
