<?php namespace Nova\Genres\Http\Controllers;

use Controller;
use Nova\Genres\Rank;
use Nova\Genres\RankInfo;
use Nova\Genres\RankGroup;
use Symfony\Component\Finder\Finder;

class RankItemsController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
	}

	public function index()
	{
		$rankClass = new Rank;

		$this->authorize('manage', $rankClass);

		// Get all of the rank groups
		$groups = RankGroup::orderBy('order')->get()->pluck('name', 'id');

		// Get all of the ranks
		$ranks = Rank::with('info')->orderBy('order')->get();

		return view('pages.genres.all-ranks', compact('rankClass', 'groups', 'ranks'));
	}

	public function create()
	{
		$this->authorize('create', new Rank);

		// Get all of the rank groups
		$groups = RankGroup::orderBy('order')->get()->pluck('name', 'id');

		// Get all of the rank info
		$info = RankInfo::orderBy('order')->get()->pluck('name', 'id');

		// Get the base images
		$finderBaseImages = (new Finder)->files()->in(base_path('ranks/st24/duty/base'));
		$baseImages = [];

		foreach ($finderBaseImages as $file) {
			$relativePath = str_replace('_', ' ', $file->getRelativePath());
			$relativePath = str_replace('\\', ' ', $relativePath);
			$relativePath = ucwords($relativePath);

			$pathName = str_replace('\\', '/', $file->getRelativePathname());

			$baseImages[$relativePath][] = $pathName;
		}

		krsort($baseImages);

		// Get the overlay images
		$finderOverlayImages = (new Finder)->files()->in(base_path('ranks/st24/duty/overlay'));
		$overlayImages = [];

		foreach ($finderOverlayImages as $file) {
			$relativePath = str_replace('_', ' ', $file->getRelativePath());
			$relativePath = str_replace('\\', ' ', $relativePath);
			$relativePath = ucwords($relativePath);

			$pathName = str_replace('\\', '/', $file->getRelativePathname());

			$overlayImages[$relativePath][] = $pathName;
		}
		// dd($overlayImages);

		return view('pages.genres.create-rank', compact('groups', 'info', 'baseImages', 'overlayImages'));
	}

	public function store()
	{
		$this->authorize('create', new Rank);

		$this->validate(request(), [
			'group_id' => 'required|exists:ranks_groups,id',
			'info_id' => 'required|exists:ranks_info,id',
		], [
			'group_id.required' => _m('genre-rank-validation-group-required'),
			'group_id.exists' => _m('genre-rank-validation-group-exists'),
			'info_id.required' => _m('genre-rank-validation-info-required'),
			'info_id.exists' => _m('genre-rank-validation-info-exists'),
		]);

		creator(Rank::class)->with(request()->all())->create();

		flash()
			->title(_m('genre-rank-flash-added-title'))
			->message(_m('genre-rank-flash-added-message'))
			->success();

		return redirect()->route('ranks.items.index');
	}

	public function edit(Rank $item)
	{
		$this->authorize('update', $item);
	}

	public function update(Rank $item)
	{
		$this->authorize('update', $item);
	}

	public function destroy(Rank $item)
	{
		$this->authorize('delete', $item);
	}

	public function reorder()
	{
		$this->authorize('update', new Rank);

		collect(request('items'))->each(function ($id, $index) {
			Rank::find($id)->reorder($index);
		});

		return response(200);
	}

	public function duplicate(Rank $item)
	{
		$this->authorize('create', $item);
	}
}
