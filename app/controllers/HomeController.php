<?php

class HomeController extends BaseController {

	public function __construct()
	{
		parent::__construct();

		// Pass a callback to do a filter instead
		$this->beforeFilter(function()
		{
			var_dump('Before filter in HomeController');
		});

		$this->afterFilter(function()
		{
			var_dump('After filter in HomeController');
		});
	}

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}

	public function actionFoo()
	{
		$view = View::make('test');
		$view->test = 'test variable';

		echo $view;
	}

	public function actionIndex()
	{
		return 'Home::Index';
	}
}