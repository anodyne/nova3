<?php namespace Nova\Genres\Http\Controllers;

use Controller;
use Nova\Genres\RankGroup;

class RanksController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');

		$this->views('admin', 'template');
	}

	public function index()
	{
		$this->authorize('manage', new RankGroup);

		$this->views('genres.ranks-landing');

		$this->setPageTitle(_m('genre-ranks', [2]));
	}
}
