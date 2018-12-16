<?php

namespace Nova\Themes\Http\Controllers;

use Nova\Themes\Theme;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Themes\Http\Responses\ThemeIndexResponse;

class ThemesController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
	}

	public function index()
	{
		return app(ThemeIndexResponse::class)->with([
			'themes' => Theme::get(),
		]);
	}

	public function create()
	{
		$this->views('themes.create-theme', 'page');
	}

	public function store()
	{
		Theme::create(request()->all());

		return redirect()->route('themes.index');
	}

	public function edit(Theme $theme)
	{
		$this->views('themes.edit-theme', 'page');

		$this->data->theme = $theme;
	}

	public function update(Theme $theme)
	{
		$theme->update(request()->all());

		return redirect()->route('themes.index');
	}
}
