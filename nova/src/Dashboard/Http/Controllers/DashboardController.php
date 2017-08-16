<?php namespace Nova\Dashboard\Http\Controllers;

use Controller;

class DashboardController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
	}

	public function characters()
	{
		$this->user->load('characters.position');

		$characters = $this->user->characters;

		return view('pages.dashboard.characters', compact('characters'));
	}
}
