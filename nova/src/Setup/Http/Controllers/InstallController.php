<?php namespace Nova\Setup\Http\Controllers;

use Flash,
	Input,
	Artisan,
	UserCreator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Cache\Repository as Cache;

class InstallController extends Controller {

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

		// Grab the content from the generator
		$content = $files->get(app_path('Setup/generators/session.php'));

		// Create the file and store the content
		$files->put(app('path.config').'/session.php', $content);
	}

	public function novaSuccess()
	{
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

	public function createUser(UserCreator $userCreator)
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

}
