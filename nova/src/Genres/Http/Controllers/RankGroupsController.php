<?php namespace Nova\Genres\Http\Controllers;

use Controller;
use Nova\Genres\RankGroup;
use Symfony\Component\Finder\Finder;

class RankGroupsController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
	}

	public function index()
	{
		$rankGroupClass = new RankGroup;

		$this->authorize('manage', $rankGroupClass);

		$rankGroups = RankGroup::orderBy('order')->get();

		return view('pages.genres.all-rank-groups', compact('rankGroups', 'rankGroupClass'));
	}

	public function create()
	{
		$this->authorize('create', new RankGroup);

		if (session()->has('return-to-ranks')) {
			session()->reflash();
		}

		return view('pages.genres.create-rank-group');
	}

	public function store()
	{
		$this->authorize('create', new RankGroup);

		$this->validate(request(), [
			'name' => 'required',
		], [
			'name.required' => _m('validation-name-required'),
		]);

		creator(RankGroup::class)->with(request()->all())->create();

		flash()
			->title(_m('genre-rank-groups-flash-added-title'))
			->message(_m('genre-rank-groups-flash-added-message'))
			->success();

		if (session()->has('return-to-ranks')) {
			return redirect()->route('ranks.items.create');
		}

		return redirect()->route('ranks.groups.index');
	}

	public function update()
	{
		$this->authorize('update', new RankGroup);

		$this->validate(request(), [
			'groups.*.name' => 'required',
		], [
			'groups.*.name.required' => _m('validation-name-required'),
		]);

		updater(RankGroup::class)->with(request('groups'))->updateAll();

		return response(200);
	}

	public function destroy(RankGroup $group)
	{
		$this->authorize('delete', $group);

		deletor(RankGroup::class)->delete($group);

		return response($group, 200);
	}

	public function reorder()
	{
		$this->authorize('update', new RankGroup);

		collect(request('groups'))->each(function ($id, $index) {
			RankGroup::find($id)->reorder($index);
		});

		return response(200);
	}

	public function duplicate(RankGroup $group)
	{
		$this->authorize('create', $group);

		duplicator(RankGroup::class)->with(request()->all())->duplicate($group);

		flash()
			->title(_m('genre-rank-groups-flash-duplicated-title'))
			->message(_m('genre-rank-groups-flash-duplicated-message'))
			->success();

		return redirect()->route('ranks.groups.index');
	}

	public function duplicateConfirm()
	{
		$this->authorize('create', new RankGroup);

		// Get the path to the rank folder
		$rankPath = base_path('ranks/'.Settings::find(1)->value);

		// Get the base images
		$finderBaseImages = (new Finder)->files()->in("{$rankPath}/base");
		$baseImages = [];

		foreach ($finderBaseImages as $file) {
			$pathName = str_replace('\\', '/', $file->getRelativePathname());

			$baseImages[$pathName] = $pathName;
		}

		// Grab the group ID from the request string
		$group = request('group');

		return view('pages.genres._rank-group-duplicate', compact('baseImages', 'group'));
	}
}
