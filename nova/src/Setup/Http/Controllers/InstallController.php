<?php namespace Nova\Setup\Http\Controllers;

use Str,
	Flash,
	Input,
	Artisan,
	UserCreator,
	SettingRepositoryInterface;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Cache\Repository as Cache;
use Nova\Setup\Http\Requests\CreateUserRequest,
	Nova\Setup\Http\Requests\UpdateSettingsRequest;

class InstallController extends BaseController {

	public function index()
	{
		return view('pages.setup.install.landing');
	}

	public function installLanding()
	{
		return view('pages.setup.install.nova');
	}

	public function install(Cache $cache, Filesystem $files)
	{
		// Run the migrate commands
		Artisan::call('migrate', ['--force' => true]);

		// Set the installed cache item
		$cache->forever('nova.installed', (bool) true);

		// Cache the routes in production
		if (app('env') == 'production')
		{
			Artisan::call('route:cache');
		}
	}

	public function novaSuccess(Filesystem $files)
	{
		// Get an instance of the writer
		$writer = app('nova.setup.configWriter');

		// Write the app config file
		$writer->write('app', [
			'#APP_KEY#' => Str::random(32),
		]);

		// Write the session config file
		$writer->write('session');

		return view('pages.setup.install.nova-success');
	}

	public function user()
	{
		return view('pages.setup.install.user');
	}

	public function userSuccess()
	{
		return view('pages.setup.install.user-success');
	}

	public function createUser(UserCreator $userCreator, CreateUserRequest $request)
	{
		// Create a new user and character
		$creator = $userCreator->create(Input::all());

		if ($creator)
		{
			return redirect()->route('setup.install.user.success');
		}

		Flash::error("User and character could not be created.");

		return redirect()->route('setup.install.user');
	}

	public function settings()
	{
		$settings = ['sim_name'];

		return view('pages.setup.install.settings', compact('settings'));
	}

	public function settingsSuccess()
	{
		return view('pages.setup.install.settings-success');
	}

	public function updateSettings(SettingRepositoryInterface $repo, UpdateSettingsRequest $request)
	{
		// Update the settings
		$update = $repo->update(Input::except(['_token']));

		if ($update)
		{
			return redirect()->route('setup.install.settings.success');
		}

		Flash::error("User and character could not be created.");

		return redirect()->route('setup.install.settings');
	}

}
