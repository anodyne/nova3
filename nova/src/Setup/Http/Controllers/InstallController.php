<?php namespace Nova\Setup\Http\Controllers;

use Status;
use Artisan;
use Nova\Users\User;
use Nova\Setup\Http\Requests;
use Nova\Foundation\SystemInfo;
use Nova\Setup\ConfigFileWriter;
use Illuminate\Filesystem\Filesystem;

class InstallController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('nova.auth-setup');
	}

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
		// Make sure we have enough time to do everything
		ini_set('max_execution_time', 60);

		// Run the install process
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
		$hasUser = User::count() > 0;

		return view('setup.install.user', compact('hasUser'));
	}

	public function userSuccess()
	{
		return view('setup.install.user-success');
	}

	public function createUser(Requests\CreateUserRequest $request)
	{
		// Create a new user
		$user = creator('Nova\Users\User')
			->with(array_merge(
				$request->get('user'),
				['status' => Status::ACTIVE]
			))
			->create();

		// Create a new character
		$character = creator('Nova\Characters\Character')
			->with(array_merge(
				$request->get('character'),
				[
					'user_id' => $user->id,
					'rank_id' => $request->get('rank_id'),
					'positions' => $request->get('positions'),
					'status' => Status::ACTIVE
				]
			))
			->create()
			->setAsPrimaryCharacter();

		if ($user and $character) {
			return redirect()->route('setup.install.user.success');
		}

		flash()
			->message('User and/or character could not be created.')
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

	public function updateSettings(Requests\UpdateSettingsRequest $request)
	{
		// Update the settings
		updater('Nova\Settings\Settings')
			->with(request()->all())
			->updateAll();

		// Set the install phase
		SystemInfo::first()->setPhase('install', 1);

		return redirect()->route('setup.install.settings.success');
	}
}
