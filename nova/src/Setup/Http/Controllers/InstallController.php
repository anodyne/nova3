<?php namespace Nova\Setup\Http\Controllers;

use Str,
	Flash,
	Input,
	Status,
	Artisan,
	UserCreator,
	SettingRepositoryContract,
	PageContentRepositoryContract;
use Illuminate\Filesystem\Filesystem,
	Illuminate\Filesystem\FilesystemManager;
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

	public function install(FilesystemManager $storage)
	{
		// Run the migrate commands
		Artisan::call('migrate', ['--force' => true]);

		// Create the installed file
		$storage->disk('local')->put('installed.json', json_encode(['installed' => true]));

		// Cache the routes in production
		if (app('env') == 'production')
		{
			Artisan::call('route:cache');
		}
	}

	public function novaSuccess()
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
		$creator = $userCreator->createWithCharacter($request->all());

		if ($creator)
		{
			$user = app('UserRepository')->getById(1);
			$user->status = Status::ACTIVE;
			$user->save();

			return redirect()->route('setup.install.user.success');
		}

		flash()->error(null, "User and character could not be created.");

		return redirect()->route('setup.install.user');
	}

	public function settings()
	{
		$themes = [
			'pulsar' => 'Pulsar'
		];

		return view('pages.setup.install.settings', compact('themes'));
	}

	public function settingsSuccess()
	{
		return view('pages.setup.install.settings-success');
	}

	public function updateSettings(SettingRepositoryContract $settings, 
			PageContentRepositoryContract $content,
			UpdateSettingsRequest $request)
	{
		// Grab the data
		$data = request()->except(['_token']);

		// We need to handle content data separately because of the
		// fact that content keys can have periods and setting keys
		// cannot have periods
		$contentData = $data;

		// Update the settings
		$update = $settings->updateByKey($data);

		// Update the keys we're using
		array_walk($data, function ($value, $key) use (&$contentData)
		{
			// Replace underscores with periods
			$newKey = str_replace('_', '.', $key);

			$contentData[$newKey] = $value;
		});

		// Update the content
		$content->updateByKey($contentData);

		if ($update)
		{
			return redirect()->route('setup.install.settings.success');
		}

		flash()->error(null, "Settings could not be updated.");

		return redirect()->route('setup.install.settings');
	}

}
