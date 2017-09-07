<?php namespace Nova\Dashboard\Http\Controllers;

use Controller;

class DashboardController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
	}

	public function index()
	{
		return view('pages.dashboard.index');
	}

	public function characters()
	{
		$this->user->loadMissing('characters.positions');

		$characters = $this->user->characters;

		return view('pages.dashboard.characters', compact('characters'));
	}
}
