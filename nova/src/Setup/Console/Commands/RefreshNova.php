<?php namespace Nova\Setup\Console\Commands;

use Status;
use Artisan;
use Nova\Authorize\Role;
use Nova\Genres\Position;
use Illuminate\Console\Command;
use Nova\Setup\ConfigFileWriter;
use Illuminate\Filesystem\FilesystemManager;

class RefreshNova extends Command
{
	protected $name = 'nova:refresh';
	protected $description = 'Refresh Nova with a fresh copy of the database and data';

	protected $files;
	protected $writer;

	public function __construct(FilesystemManager $storage, ConfigFileWriter $writer)
	{
		parent::__construct();
		
		$this->files = $storage->disk('local');
		$this->writer = $writer;
	}

	public function handle()
	{
		/**
		 * Remove Nova and clear all the caches.
		 */
		$this->call('nova:uninstall', ['--quiet' => true]);

		/**
		 * Install a fresh copy of Nova.
		 */
		$this->call('nova:install', ['--quiet' => true]);

		/**
		 * Add the config files we need to ensure Nova doesn't think
		 * it hasn't been properly installed.
		 */
		$this->writer->write('database', [
			"#DB_DRIVER#"	=> 'mysql',
			"#DB_HOST#"		=> '',
			"#DB_DATABASE#"	=> '',
			"#DB_USERNAME#"	=> '',
			"#DB_PASSWORD#"	=> '',
			"#DB_PREFIX#"	=> '',
		]);
		$this->writer->write('mail', [
			"#MAIL_DRIVER#" => '',
			"#MAIL_HOST#" => '',
			"#MAIL_PORT#" => '',
			"#MAIL_ENCRYPTION#" => '',
			"#MAIL_USERNAME#" => '',
			"#MAIL_PASSWORD#" => '',
			"#MAIL_SENDMAIL_PATH#" => '',
		]);
		$this->writer->write('session');
		$this->info(config('nova.app.name').' installation cleanup completed.');

		/**
		 * Create some test users.
		 */
		// Create a user with the System Admin role
		$admin = factory('Nova\Users\User')->create([
			'name' => "Adam Doe",
			'email' => "admin@example.com",
			'remember_token' => null,
			'status' => Status::ACTIVE,
		]);
		$admin->attachRole(Role::name('System Admin')->first());
		$admin->attachRole(Role::name('Active User')->first());

		// Create a user with the Active User role
		$user = factory('Nova\Users\User')->create([
			'name' => "Ben Doe",
			'email' => "user@example.com",
			'remember_token' => null,
			'status' => Status::ACTIVE,
		]);
		$user->attachRole(Role::name('Active User')->first());

		$this->info('Created test users.');

		/**
		 * Create some test characters.
		 */
		$character1 = factory('Nova\Characters\Character')->create([
			'name' => 'Jean-Luc Picard',
			'status' => Status::ACTIVE,
			'user_id' => $admin->id,
			'rank_id' => 9,
		]);
		$character1->positions()->sync([1]);
		$character1->setAsPrimaryCharacter();
		Position::find(1)->removeAvailableSlot();

		$character2 = factory('Nova\Characters\Character')->create([
			'name' => 'William Riker',
			'status' => Status::ACTIVE,
			'user_id' => $user->id,
			'rank_id' => 10,
		]);
		$character2->positions()->sync([2]);
		$character2->setAsPrimaryCharacter();
		Position::find(2)->removeAvailableSlot();

		$character3 = factory('Nova\Characters\Character')->create([
			'name' => 'Data',
			'status' => Status::ACTIVE,
			'user_id' => null,
			'rank_id' => 25,
		]);
		$character3->positions()->sync([23,3]);
		Position::find(23)->removeAvailableSlot();
		Position::find(3)->removeAvailableSlot();

		$character4 = factory('Nova\Characters\Character')->create([
			'name' => 'Geordi LaForge',
			'status' => Status::ACTIVE,
			'user_id' => null,
			'rank_id' => 25,
		]);
		$character4->positions()->sync([29]);
		Position::find(29)->removeAvailableSlot();

		$character5 = factory('Nova\Characters\Character')->create([
			'name' => 'Worf',
			'status' => Status::ACTIVE,
			'user_id' => null,
			'rank_id' => 26,
		]);
		$character5->positions()->sync([16]);
		Position::find(16)->removeAvailableSlot();

		$character6 = factory('Nova\Characters\Character')->create([
			'name' => 'Deanna Troi',
			'status' => Status::ACTIVE,
			'user_id' => null,
			'rank_id' => 39,
		]);
		$character6->positions()->sync([47]);
		Position::find(47)->removeAvailableSlot();

		$character7 = factory('Nova\Characters\Character')->create([
			'name' => 'Beverly Crusher',
			'status' => Status::ACTIVE,
			'user_id' => null,
			'rank_id' => 38,
		]);
		$character7->positions()->sync([46]);
		Position::find(46)->removeAvailableSlot();

		$character7 = factory('Nova\Characters\Character')->create([
			'name' => 'Wesley Crusher',
			'status' => Status::ACTIVE,
			'user_id' => $user->id,
			'rank_id' => 14,
		]);
		$character7->positions()->sync([9]);
		Position::find(9)->removeAvailableSlot();

		$this->info('Created test characters.');
	}
}
