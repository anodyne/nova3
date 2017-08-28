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
				'positions.characters.positions',
				'subDepartments.positions.characters.rank.info',
				'subDepartments.positions.characters.positions'
			])
			->orderBy('order')
			->get();

		$character1 = \Nova\Characters\Character::find(3);
		$character2 = \Nova\Characters\Character::find(2);

		$position = \Nova\Genres\Position::find(1);

		return view('pages.characters.manifest', compact('departments', 'character1', 'character2', 'position'));
	}
}
