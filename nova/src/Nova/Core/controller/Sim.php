<?php

namespace Nova\Core\Controller;

class Sim extends \Controller {

	/*public function __construct()
	{
		parent::__construct();

		$this->beforeFilter(function()
		{
			\Debug::dump('Controller::before');
		});

		$this->afterFilter(function()
		{
			\Debug::dump('Controller::after');
		});
	}*/

	public function actionIndex()
	{
		$settings = new \stdClass;
		$settings->meta_description = '';
		$settings->meta_keywords = '';
		$settings->meta_author = '';

		return \View::make('components/structure/main', array(
			'skin'		=> 'default',
			'sec'		=> 'main',
			'settings'	=> $settings,
		))
			->with('title', 'Title')
			->with('layout', false);
	}
}