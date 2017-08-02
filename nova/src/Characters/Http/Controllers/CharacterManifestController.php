<?php namespace Nova\Characters\Http\Controllers;

use Controller;
use Nova\Genres\Department;

class CharacterManifestController extends Controller
{
	public function index()
	{
		$departments = Department::parents()
			->where('display', (int) true)
			->with([
				'positions.characters.rank.info',
				'positions.characters.position',
				'subDepartments.positions.characters.rank.info',
				'subDepartments.positions.characters.position'
			])
			->orderBy('order')
			->get();

		return view('pages.characters.manifest', compact('departments'));
	}
}
