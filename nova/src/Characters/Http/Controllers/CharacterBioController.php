<?php namespace Nova\Characters\Http\Controllers;

use Controller;
use Nova\Characters\Character;

class CharacterBioController extends Controller
{
	public function show(Character $character)
	{
		$character->load('positions');

		return view('pages.characters.bio', compact('character'));
	}
}
