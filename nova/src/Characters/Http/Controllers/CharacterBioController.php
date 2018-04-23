<?php namespace Nova\Characters\Http\Controllers;

use Controller;
use Nova\Characters\Character;

class CharacterBioController extends Controller
{
	public function show(Character $character)
	{
		$this->views('characters.bio');

		$this->setPageTitle($character->name);

		$this->data->character = $character->load('positions');
		$this->data->images = $character->media->where('primary', (int)false);
	}
}
