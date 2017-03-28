<?php namespace Nova\Setup\Http\Controllers;

use Date;
use Status;
use Artisan;
use Illuminate\Database\DatabaseManager;

class MigrateController extends BaseController
{
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

	public function migrateSuccess()
	{
		// Get an instance of the writer
		$writer = app('nova.configWriter');

		// Write the session config file
		$writer->write('session');

		return view('pages.setup.migrate.nova-success');
	}

	public function runMigration()
	{
		$this->installNova();

		$this->migrateUsers();
	}

	public function accounts()
	{
		return view('pages.setup.migrate.accounts');
	}

	public function updateAccounts()
	{
		// TODO: remove the Nova 2 config file
	}

	protected function installNova()
	{
		Artisan::call('nova:install');
	}

	protected function migrateUsers()
	{
		$self = $this;

		$this->db->table('users')
			->orderBy('userid')
			->chunk(100, function ($users) use (&$self) {
				$users->each(function ($user) use (&$self) {
					$newUser = app('nova.userCreator')->create([
						'name' => $user->name,
						'email' => $user->email,
						'password' => config('nova2.temp_password'),
						'status' => Status::toInt($user->status),
						'created_at' => Date::createFromTimestampUTC($user->join_date),
						'deleted_at' => (empty($user->leave_date)) ? null : Date::createFromTimestampUTC($user->leave_date),
					]);
					//$newUser->roles()->attach();

					//$preferences = [];
					//$newUser->prefs()->create($preferences);

					$self->userDictionary[$user->userid] = $newUser->id;
				});
			});
	}
}
