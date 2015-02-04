<?php namespace Nova\Setup\Http\Controllers;

use Str,
	Flash,
	Input,
	Artisan,
	UserCreator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Cache\Repository as Cache;
use Nova\Setup\Http\Requests\CreateUserRequest;

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

		// Cache the routes
		Artisan::call('route:cache');
	}

	public function novaSuccess(Filesystem $files)
	{
		// Write the app config file
		$this->writeConfigFile($files, 'app', [
			'#APP_KEY#' => Str::random(32),
		]);

		// Write the session config file
		$this->writeConfigFile($files, 'session');

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

	protected function writeConfigFile(Filesystem $files, $config, array $replacements = [])
	{
		// Grab the content from the generator
		$content = $files->get(app_path("Setup/generators/{$config}.php"));

		if (count($replacements) > 0)
		{
			foreach ($replacements as $placeholder => $replacement)
			{
				$content = str_replace($placeholder, $replacement, $content);
			}
		}

		// Create the file and store the content
		$files->put(app('path.config')."/{$config}.php", $content);
	}

}
