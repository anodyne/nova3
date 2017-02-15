<?php namespace Nova\Setup\Http\Controllers;

use Artisan;
use Illuminate\Filesystem\Filesystem,
	Illuminate\Filesystem\FilesystemManager;
use Illuminate\Database\DatabaseManager;

// The new database cannot have the same database prefix as the old database

class MigrateController extends BaseController {

	protected $db;
	protected $userDictionary = [];
	protected $characterDictionary = [];

	public function __construct(DatabaseManager $db)
	{
		parent::__construct();

		$this->db = $db->connection('nova2');
	}

	public function index()
	{
		return view('pages.setup.migrate.landing');
	}

	public function migrateLanding()
	{
		return view('pages.setup.migrate.nova');
	}

	public function runMigration(FilesystemManager $storage)
	{
		$this->installNova($storage);

		$this->migrateUsers();
	}

	protected function installNova(FilesystemManager $storage)
	{
		Artisan::call('nova:install');
		/*Artisan::call('migrate', ['--force' => true]);

		$storage->disk('local')->put('installed.json', json_encode(['installed' => true]));

		if (app('env') == 'production') {
			Artisan::call('route:cache');
		}*/
	}

	protected function migrateUsers()
	{
		$self = $this;

		$this->db->table('users')->chunk(100, function ($user) use (&$self) {

			$userData = [];

			$newUser = new UserCreator($userData);
			$newUser->roles()->attach();

			$preferences = [];
			$newUser->prefs()->create($preferences);

			$self->userDictionary[$user->userid] = $newUser->id;
		});
	}
}
