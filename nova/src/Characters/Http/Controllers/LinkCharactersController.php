<?php namespace Nova\Characters\Http\Controllers;

use Controller;

class LinkCharactersController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
	}

	public function create()
	{
		return view('pages.characters.quick-link');
	}

	public function store()
	{
		# code...
	}
}
