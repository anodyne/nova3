<?php namespace Nova\Settings\Http\Controllers;

use Controller;
use Nova\Settings\Settings;

class SettingsController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
	}

	public function index()
	{
		$this->authorize('manage', new Settings);

		$settings = Settings::get()->pluck('value', 'key');

		return view('pages.settings.all-settings', compact('settings'));
	}

	public function update()
	{
		$this->authorize('update', new Settings);

		updater(Settings::class)->with(request()->all())->updateAll();

		return response(200);
	}
}
