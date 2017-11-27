<?php namespace Nova\Setup\Http\Controllers;

use DB;
use Date;
use Status;
use Artisan;
use Nova\Genres\Rank;
use Nova\Setup\Http\Requests;
use Nova\Characters\Character;
use Nova\Foundation\SystemInfo;
use Nova\Setup\Migrations\MigrationManager;

class MigrateController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('nova.auth-setup');
	}

	public function index()
	{
		return view('setup.migrate.landing');
	}

	public function migrateLanding()
	{
		return view('setup.migrate.nova');
	}

	public function migrateSuccess()
	{
		// Get an instance of the writer
		$writer = app('nova.configWriter');

		// Write the session config file
		$writer->write('session');

		return view('setup.migrate.nova-success');
	}

	public function runSingleMigration($key)
	{
		return app('nova2-migrator')->run($key);
	}

	public function verifyCharacters()
	{
		// Get all of the ranks
		$ranks = Rank::with('info', 'group')->get();

		// Get all of the characters
		$characters = Character::with('user', 'positions')->get();

		// Make sure we have a way to mark a character as verified
		$characters = $characters->map(function ($c) {
			return array_merge($c->toArray(), ['finished' => false]);
		});

		return view('setup.migrate.characters', compact('characters', 'ranks'));
	}

	public function updateCharacters()
	{
		collect(request('characters'))->each(function ($c) {
			Character::find($c['id'])->update(['rank_id' => $c['rank']]);
		});
	}

	public function charactersSuccess()
	{
		return view('setup.migrate.characters-success');
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
		return view('setup.migrate.settings-success');
	}

	public function updateSettings(Requests\UpdateSettingsRequest $request)
	{
		// Update the settings
		updater('Nova\Settings\Settings')
			->with(request()->all())
			->updateAll();

		// Set the migration phase
		SystemInfo::first()->setPhase('migration', 1);

		return redirect()->route('setup.migrate.settings.success');
	}
}
