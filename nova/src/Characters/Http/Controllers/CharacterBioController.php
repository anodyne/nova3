<?php namespace Nova\Characters\Http\Controllers;

use Controller;
use Nova\Characters\Character;

class CharacterBioController extends Controller
{
	public function show(Character $character)
	{
		// Make sure we load all the positions
		$character->load('positions');

		// Make sure the images we have don't include the primary media
		$images = $character->media->where('primary', (int)false);

		return view('pages.characters.bio', compact('character', 'images'));
	}
}
