<?php namespace Nova\Settings\Http\Controllers;

use Controller;
use Nova\Settings\Settings;

class SettingsController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');

		$this->views->put('structure', 'admin');
		$this->views->put('template', 'admin');
	}

	public function index()
	{
		$this->authorize('manage', new Settings);

		$this->pageTitle = 'Settings';

		$this->views->put('page', 'settings.settings');
		$this->views->put('scripts', 'settings.settings');

		$this->data->settings = Settings::get()->pluck('value', 'key');
	}

	public function update()
	{
		$this->authorize('update', new Settings);

		$this->isAjax = true;

		updater(Settings::class)->with(request()->all())->updateAll();

		return response(200);
	}
}
