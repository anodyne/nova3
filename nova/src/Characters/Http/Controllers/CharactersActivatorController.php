<?php namespace Nova\Characters\Http\Controllers;

use Controller;
use Nova\Characters\Character;

class CharactersActivatorController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
	}

	public function update(Character $character)
	{
		$this->authorize('update', $character);

		updater(Character::class)->activate($character);

		return response($character, 200);
	}

	public function destroy(Character $character)
	{
		$this->authorize('update', $character);

		updater(Character::class)->deactivate($character);

		return response($character, 200);
	}
}
