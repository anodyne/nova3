<?php namespace Nova\Setup\Http\Controllers;

use Status;
use Artisan;
use Nova\Setup\ConfigFileWriter;
use Illuminate\Filesystem\Filesystem;

class InstallController extends Controller
{
	public function index()
	{
		return view('setup.install.landing');
	}

	public function installLanding()
	{
		return view('setup.install.nova');
	}

	public function install()
	{
		Artisan::call('nova:install');
	}

	public function novaSuccess(ConfigFileWriter $writer, Filesystem $files)
	{
		// Write the session config file
		if (! $files->exists(app()->appConfigPath('session.php'))) {
			$writer->write('session');
		}

		return view('setup.install.nova-success');
	}

	public function user()
	{
		return view('setup.install.user');
	}

	public function userSuccess()
	{
		return view('setup.install.user-success');
	}

	public function createUser(CreateUserRequest $request)
	{
		// Create a new user and character
		$creator = $userCreator->createWithCharacter($request->all());

		if ($creator) {
			$user = app('UserRepository')->getById(1);
			$user->status = Status::ACTIVE;
			$user->save();

			return redirect()->route('setup.install.user.success');
		}

		flash()
			->message('User and character could not be created.')
			->error();

		return redirect()->route('setup.install.user');
	}

	public function settings()
	{
		$themes = [
			'pulsar' => 'Pulsar'
		];

		return view('setup.install.settings', compact('themes'));
	}

	public function settingsSuccess()
	{
		return view('setup.install.settings-success');
	}

	public function updateSettings(
		SettingRepositoryContract $settings,
		PageContentRepositoryContract $content,
		UpdateSettingsRequest $request
	) {
		// Grab the data
		$data = request()->except(['_token']);

		// We need to handle content data separately because of the
		// fact that content keys can have periods and setting keys
		// cannot have periods
		$contentData = $data;

		// Update the settings
		$update = $settings->updateByKey($data);

		// Update the keys we're using
		array_walk($data, function ($value, $key) use (&$contentData) {
			// Replace underscores with periods
			$newKey = str_replace('_', '.', $key);

			$contentData[$newKey] = $value;
		});

		// Update the content
		$content->updateByKey($contentData);

		if ($update) {
			return redirect()->route('setup.install.settings.success');
		}

		flash()->error(null, "Settings could not be updated.");

		return redirect()->route('setup.install.settings');
	}
}
