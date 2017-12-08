<?php namespace Nova\Genres\Http\Controllers;

use Controller;
use Nova\Genres\Rank;
use Nova\Genres\RankInfo;
use Nova\Genres\RankGroup;
use Nova\Settings\Settings;
use Symfony\Component\Finder\Finder;

class RankItemsController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');

		$this->views('admin', 'structure|template');
	}

	public function index()
	{
		$rankClass = new Rank;

		$this->authorize('manage', $rankClass);

		$this->views('genres.all-ranks', 'page|script');

		$this->pageTitle = _m('genre-ranks', [2]);

		$this->data->rankClass = $rankClass;
		$this->data->groups = RankGroup::orderBy('order')->get()->pluck('name', 'id');
		$this->data->ranks = Rank::with('info')->orderBy('order')->get();
	}

	public function create()
	{
		$this->authorize('create', new Rank);

		$this->views('genres.create-rank', 'page|script');

		$this->pageTitle = _m('genre-ranks-add');

		$rankPath = base_path('ranks/'.Settings::item('rank')->first()->value);

		// Get the base images
		$finderBaseImages = (new Finder)->files()->in("{$rankPath}/base");
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
		$finderOverlayImages = (new Finder)->files()->in("{$rankPath}/overlay");
		$overlayImages = [];

		foreach ($finderOverlayImages as $file) {
			$relativePath = str_replace('_', ' ', $file->getRelativePath());
			$relativePath = str_replace('\\', ' ', $relativePath);
			$relativePath = ucwords($relativePath);

			$pathName = str_replace('\\', '/', $file->getRelativePathname());

			$overlayImages[$relativePath][] = $pathName;
		}

		// Store something in the session in case we go out to create a group or info
		session()->flash('return-to-ranks', true);

		$this->data->groups = RankGroup::orderBy('order')->get()->pluck('name', 'id');
		$this->data->info = RankInfo::orderBy('order')->get()->pluck('name', 'id');
		$this->data->baseImages = $baseImages;
		$this->data->overlayImages = $overlayImages;
	}

	public function store()
	{
		$this->renderWithTheme = false;

		$this->authorize('create', new Rank);

		$this->validate(request(), [
			'group_id' => 'required|exists:ranks_groups,id',
			'info_id' => 'required|exists:ranks_info,id',
		], [
			'group_id.required' => _m('genre-ranks-validation-group-required'),
			'group_id.exists' => _m('genre-ranks-validation-group-exists'),
			'info_id.required' => _m('genre-ranks-validation-info-required'),
			'info_id.exists' => _m('genre-ranks-validation-info-exists'),
		]);

		creator(Rank::class)->with(request()->all())->create();

		flash()
			->title(_m('genre-ranks-flash-added-title'))
			->message(_m('genre-ranks-flash-added-message'))
			->success();

		session()->forget('return-to-ranks');

		return redirect()->route('ranks.items.index');
	}

	public function edit(Rank $item)
	{
		$this->authorize('update', $item);

		$this->views('genres.edit-rank', 'page|script');

		$this->pageTitle = _m('genre-ranks-update');

		// Set the path to the correct rank folder
		$rankPath = base_path('ranks/'.Settings::item('rank')->first()->value);

		// Get the base images
		$finderBaseImages = (new Finder)->files()->in("{$rankPath}/base");
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
		$finderOverlayImages = (new Finder)->files()->in("{$rankPath}/overlay");
		$overlayImages = [];

		foreach ($finderOverlayImages as $file) {
			$relativePath = str_replace('_', ' ', $file->getRelativePath());
			$relativePath = str_replace('\\', ' ', $relativePath);
			$relativePath = ucwords($relativePath);

			$pathName = str_replace('\\', '/', $file->getRelativePathname());

			$overlayImages[$relativePath][] = $pathName;
		}

		$this->data->groups = RankGroup::orderBy('order')->get()->pluck('name', 'id');
		$this->data->info = RankInfo::orderBy('order')->get()->pluck('name', 'id');
		$this->data->item = $item;
		$this->data->baseImages = $baseImages;
		$this->data->overlayImages = $overlayImages;
	}

	public function update(Rank $item)
	{
		$this->renderWithTheme = false;

		$this->authorize('update', $item);

		$this->validate(request(), [
			'group_id' => 'required|exists:ranks_groups,id',
			'info_id' => 'required|exists:ranks_info,id',
		], [
			'group_id.required' => _m('genre-ranks-validation-group-required'),
			'group_id.exists' => _m('genre-ranks-validation-group-exists'),
			'info_id.required' => _m('genre-ranks-validation-info-required'),
			'info_id.exists' => _m('genre-ranks-validation-info-exists'),
		]);

		updater(Rank::class)->with(request()->all())->update($item);

		flash()
			->title(_m('genre-ranks-flash-updated-title'))
			->message(_m('genre-ranks-flash-updated-message'))
			->success();

		return redirect()->route('ranks.items.index');
	}

	public function destroy(Rank $item)
	{
		$this->renderWithTheme = false;

		$this->authorize('delete', $item);

		deletor(Rank::class)->delete($item);

		return response($item, 200);
	}

	public function reorder()
	{
		$this->renderWithTheme = false;

		$this->authorize('update', new Rank);

		collect(request('items'))->each(function ($id, $index) {
			Rank::find($id)->reorder($index);
		});

		return response(200);
	}

	public function duplicate(Rank $item)
	{
		$this->renderWithTheme = false;

		$this->authorize('create', $item);

		$newItem = duplicator(Rank::class)->with(request()->all())->duplicate($item);

		flash()
			->title(_m('genre-ranks-flash-duplicated-title'))
			->message(_m('genre-ranks-flash-duplicated-message'))
			->success();

		return response($newItem, 200);
	}
}
