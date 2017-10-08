<?php namespace Nova\Characters\Http\Controllers;

use Controller;
use Nova\Genres\Department;
use Nova\Settings\Settings;

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

		$settingsClass = new Settings;

		return view('pages.characters.manifest', compact('departments', 'settingsClass'));
	}
}
