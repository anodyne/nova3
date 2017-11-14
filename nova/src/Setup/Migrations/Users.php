<?php namespace Nova\Setup\Migrations;

use Date;
use Status;
use Eloquent;
use Nova\Users\User;
use Nova\Authorize\Role;

class Users extends Migrator implements Migratable
{
	protected $users;
	protected $userDictionary;

	public function migrate()
	{
		// Get all of the users from Nova 2
		$this->users = $this->db->table('users')->get();

		// Build an array up to store user ID translation
		$userDictionary = [];

		if (! $this->check()) {
			Eloquent::unguard();

			$this->users->each(function ($user) use (&$userDictionary) {
				// Set the created_at field
				$createdAt = (! empty($user->join_date))
					? Date::createFromTimeStampUTC($user->join_date)
					: Date::now();

				$newUser = creator(User::class)->with([
					'name' => $user->name,
					'email' => $user->email,
					'status' => Status::toInt($user->status),
					'created_at' => $createdAt,
				])->create();

				// Every user has the Active User role
				if ($user->status == 'active') {
					$newUser->attachRole(Role::name('Active User')->first());
				}

				// TODO: what should we do about inactive users?
				// TODO: what should we do about pending users?

				// If the user is a sys admin, assign the System Admin role
				if ($user->is_sysadmin == 'y') {
					$newUser->attachRole(Role::name('System Admin')->first());
				}

				$userDictionary[$user->userid] = [
					'id' => $newUser->id,
					'main_character' => $user->main_char
				];
			});

			Eloquent::reguard();

			$this->userDictionary = $userDictionary;
		}

		return $this;
	}

	public function check()
	{
		return ((int)User::count() === (int)$this->users->count());
	}

	public function status()
	{
		if ($this->check()) {
			return ['status' => 'success', 'message' => ''];
		}

		return ['status' => 'failed', 'message' => 'All users were not properly migrated.'];
	}

	public function setData()
	{
		session(['nova2.users' => $this->userDictionary]);

		return $this;
	}
}
