<?php namespace Nova\Characters\Http\Controllers;

use Controller;
use Nova\Characters\Character;

class CharactersController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');

		$this->views('admin', 'structure|template');
	}

	public function index()
	{
		$characterClass = new Character;

		$this->authorize('manage', $characterClass);

		$this->views('characters.all-characters', 'page|script');

		$this->pageTitle = _m('characters', [2]);

		$this->data->characterClass = $characterClass;
		$this->data->characters = Character::withTrashed()
			->with(['positions', 'user'])
			->orderBy('name')
			->get();
	}

	public function create()
	{
		$this->authorize('create', new Character);

		$this->views('characters.create-character', 'page|script');

		$this->pageTitle = _m('characters-add');
	}

	public function store()
	{
		$this->renderWithTheme = false;

		$this->authorize('create', new Character);

		$this->validate(request(), [
			'name' => 'required',
			'positions.*' => 'required|exists:positions,id',
		], [
			'name.required' => _m('validation-name-required'),
			'positions.*.required' => _m('characters-validation-position-required'),
			'positions.*.exists' => _m('characters-validation-position-exists'),
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

		$this->views('characters.edit-character', 'page|script');

		$this->pageTitle = _m('characters-update');

		$this->data->character = $character->loadMissing(['positions.department', 'user']);
		$this->data->positions = $character->positions->map(function ($p) {
			return ['id' => $p->id];
		});
	}

	public function update(Character $character)
	{
		$this->renderWithTheme = false;

		$this->authorize('update', $character);

		$this->validate(request(), [
			'name' => 'required',
			'positions.*' => 'required|exists:positions,id',
		], [
			'name.required' => _m('validation-name-required'),
			'position.*.required' => _m('characters-validation-position-required'),
			'position.*.exists' => _m('characters-validation-position-exists'),
		]);

		// Make sure we have the old positions data as well
		$data = array_merge(request()->all(), ['old_positions' => $character->positions]);

		updater(Character::class)->with($data)->update($character);

		flash()
			->title(_m('characters-flash-updated-title'))
			->message(_m('characters-flash-updated-message'))
			->success();

		return redirect()->route('characters.index');
	}

	public function destroy(Character $character)
	{
		$this->renderWithTheme = false;

		$this->authorize('delete', $character);

		deletor(Character::class)->delete($character);

		return response($character, 200);
	}

	public function restore(Character $character)
	{
		$this->renderWithTheme = false;

		$this->authorize('update', $character);

		restorer(Character::class)->restore($character);

		return response($character, 200);
	}
}
