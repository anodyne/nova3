<?php namespace Nova\Genres\Http\Controllers;

use Controller;

class RanksController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
	}

	public function index()
	{
		return view('pages.genres.ranks');
	}
}
