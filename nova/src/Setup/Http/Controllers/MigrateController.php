<?php namespace Nova\Setup\Http\Controllers;

use Illuminate\Database\ConnectionResolverInterface;

// The new database cannot have the same database prefix as the old database

class MigrateController extends BaseController {

	protected $db;
	protected $userDictionary = [];
	protected $characterDictionary = [];

	public function __construct(ConnectionResolverInterface $db)
	{
		parent::__construct();

		$this->db = $db->connection('nova2');
	}

	public function index()
	{
		return view('pages.setup.migrate.landing');
	}

	public function runMigration()
	{
		$this->installNova();

		$this->migrateUsers();
	}

	protected function installNova()
	{
		Artisan::call('migrate', ['--force' => true]);

		$storage->disk('local')->put('installed.json', json_encode(['installed' => true]));

		if (app('env') == 'production') {
			Artisan::call('route:cache');
		}
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
