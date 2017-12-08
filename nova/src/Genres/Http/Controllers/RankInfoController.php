<?php namespace Nova\Genres\Http\Controllers;

use Controller;
use Nova\Genres\RankInfo;

class RankInfoController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');

		$this->views('admin', 'structure|template');
	}

	public function index()
	{
		$rankInfoClass = new RankInfo;

		$this->authorize('manage', $rankInfoClass);

		$this->views('genres.all-rank-info', 'page|script');

		$this->pageTitle = _m('genre-rank-info');

		$this->data->rankInfoClass = $rankInfoClass;
		$this->data->info = RankInfo::orderBy('order')->get();
	}

	public function create()
	{
		$this->authorize('create', new RankInfo);

		if (session()->has('return-to-ranks')) {
			session()->reflash();
		}

		$this->views('genres.create-rank-info');

		$this->pageTitle = _m('genre-rank-info-add');
	}

	public function store()
	{
		$this->renderWithTheme = false;

		$this->authorize('create', new RankInfo);

		$this->validate(request(), [
			'name' => 'required',
			'short_name' => 'required',
		], [
			'name.required' => _m('validation-name-required'),
			'short_name.required' => _m('genre-rank-info-validation-required-short_name'),
		]);

		creator(RankInfo::class)->with(request()->all())->create();

		flash()
			->title(_m('genre-rank-info-flash-added-title'))
			->message(_m('genre-rank-info-flash-added-message'))
			->success();

		if (session()->has('return-to-ranks')) {
			return redirect()->route('ranks.items.create');
		}

		return redirect()->route('ranks.info.index');
	}

	public function update()
	{
		$this->renderWithTheme = false;

		$this->authorize('update', new RankInfo);

		$this->validate(request(), [
			'info.*.name' => 'required',
			'info.*.short_name' => 'required',
		], [
			'info.*.name.required' => _m('validation-name-required'),
			'info.*.short_name.required' => _m('genre-rank-info-validation-required-short_name'),
		]);

		updater(RankInfo::class)->with(request('info'))->updateAll();

		return response(200);
	}

	public function destroy(RankInfo $info)
	{
		$this->renderWithTheme = false;

		$this->authorize('delete', $info);

		deletor(RankInfo::class)->delete($info);

		return response(200);
	}

	public function reorder()
	{
		$this->renderWithTheme = false;

		$this->authorize('update', new RankInfo);

		collect(request('info'))->each(function ($id, $index) {
			RankInfo::find($id)->reorder($index);
		});

		return response(200);
	}
}
