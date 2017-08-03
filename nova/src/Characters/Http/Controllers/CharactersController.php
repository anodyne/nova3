<?php namespace Nova\Characters\Http\Controllers;

use Controller;
use Nova\Characters\Character;

class CharactersController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
	}

	public function index()
	{
		$characterClass = new Character;

		$this->authorize('manage', $characterClass);

		$characters = Character::withTrashed()
			->with(['rank.info', 'position.department', 'user'])
			->get();

		return view('pages.characters.all-characters', compact('characters', 'characterClass'));
	}

	public function create()
	{
		$this->authorize('create', new Character);

		return view('pages.characters.create-character');
	}

	public function store()
	{
		$this->authorize('create', new Character);

		$this->validate(request(), [
			'name' => 'required',
			'position_id' => 'required|exists:positions,id',
		], [
			'name.required' => _m('validation-name-required'),
			'position_id.required' => _m('characters-validation-position-required'),
			'position_id.exists' => _m('characters-validation-position-exists'),
		]);

		creator(Character::class)->with(request()->all())->adminCreate();

		flash()
			->title(_m('characters-flash-added-title'))
			->message(_m('characters-flash-added-message'))
			->success();

		return redirect()->route('characters.index');
	}

	public function edit(Character $character)
	{
		$this->authorize('update', $character);

		$character->load(['position', 'rank.info', 'user']);

		return view('pages.characters.update-character', compact('character'));
	}

	public function update(Character $character)
	{
		$this->authorize('update', $character);

		$this->validate(request(), [
			'name' => 'required',
			'position_id' => 'required|exists:positions,id',
		], [
			'name.required' => _m('validation-name-required'),
			'position_id.required' => _m('characters-validation-position-required'),
			'position_id.exists' => _m('characters-validation-position-exists'),
		]);

		updater(Character::class)->with(request()->all())->update($character);

		flash()
			->title(_m('characters-flash-updated-title'))
			->message(_m('characters-flash-updated-message'))
			->success();

		return redirect()->route('characters.index');
	}

	public function destroy(Character $character)
	{
		$this->authorize('delete', $character);

		deletor(Character::class)->delete($character);

		return response($character, 200);
	}

	public function restore(Character $character)
	{
		$this->authorize('update', $character);

		restorer(Character::class)->restore($character);

		return response($character, 200);
	}
}
