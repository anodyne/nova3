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
			->with(['rank.info', 'position.department'])
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

		// $this->validate(request(), [
		// 	'name' => 'required',
		// 	'email' => 'required|email|unique:users'
		// ], [
		// 	'name.required' => _m('users-validation-name'),
		// 	'email.required' => _m('users-validation-email-required'),
		// 	'email.email' => _m('users-validation-email-email'),
		// 	'email.unique' => _m('users-validation-email-unique')
		// ]);

		creator(Character::class)->with(request()->all())->create();

		flash()
			->title(_m('characters-flash-added-title'))
			->message(_m('characters-flash-added-message'))
			->success();

		return redirect()->route('characters.index');
	}

	public function edit(Character $character)
	{
		$this->authorize('update', $character);

		$character->load('position', 'rank.info');

		return view('pages.characters.update-character', compact('character'));
	}

	public function update(Character $character)
	{
		$this->authorize('update', $character);

		// $this->validate(request(), [
		// 	'name' => 'required',
		// 	'email' => 'required|email'
		// ], [
		// 	'name.required' => _m('users-validation-name'),
		// 	'email.required' => _m('users-validation-email-required'),
		// 	'email.email' => _m('users-validation-email-email')
		// ]);

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
