<?php namespace Nova\Characters\Http\Controllers;

use Controller;
use Nova\Characters\Character;

class CharacterActivatorController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
	}

	public function update(Character $character)
	{
		$this->authorize('update', $character);

		//
	}

	public function destroy(Character $character)
	{
		$this->authorize('update', $character);

		deactivator(Character::class)->deactivate($character);

		return response($character->fresh(), 200);
	}
}
