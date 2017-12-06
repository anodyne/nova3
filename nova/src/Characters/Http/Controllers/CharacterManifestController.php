<?php namespace Nova\Characters\Http\Controllers;

use Controller;
use Nova\Genres\Department;
use Nova\Settings\Settings;

class CharacterManifestController extends Controller
{
	public function index()
	{
		$this->views('characters.manifest', 'page|script');

		$this->pageTitle = 'Manifest';

		$this->data->settingsClass = new Settings;
		$this->data->departments = Department::parents()
			->where('display', (int) true)
			->with([
				'positions.characters.rank.info',
				'positions.characters.positions',
				'subDepartments.positions.characters.rank.info',
				'subDepartments.positions.characters.positions'
			])
			->orderBy('order')
			->get();
	}
}
