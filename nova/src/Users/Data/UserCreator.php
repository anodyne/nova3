<?php namespace Nova\Users\Data;

use Str;
use Nova\Users\User;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Creatable;

class UserCreator implements Creatable
{
	use BindsData;

	protected $user;
	protected $password;
	protected $passwordWasGenerated = false;
	protected $adminCreated = false;

	public function create()
	{
		// Make sure we set a pending status on the user
		if (! $this->adminCreated) {
			// $this->data(['status' => Status::PENDING]);
		}

		// Create the user
		$user = $this->user = User::create($this->data);

		// Attach the role(s)
		if (array_key_exists('roles', $this->data)) {
			$user->roles()->attach($this->data['roles']);
		}

		// Fire any events we need to
		$this->fireEvents();

		// Reset the password stuff so we don't leave it sitting out there
		$this->password = null;
		$this->passwordWasGenerated = false;

		return $user;
	}

	public function adminCreate()
	{
		// Set the adminCreated flag
		$this->adminCreated = true;

		// Generate a password then create the user
		$this->generatePassword()->create();

		return $this->user;
	}

	public function generatePassword()
	{
		if ($this->adminCreated or ! array_key_exists('password', $this->data)) {
			// Generate a password
			$this->password = Str::random(12);

			// Set the flag that we generated a password
			$this->passwordWasGenerated = true;
		}

		return $this;
	}

	protected function fireEvents()
	{
		// Notify the user of their password
		if ($this->passwordWasGenerated) {
			event(new Events\PasswordWasGenerated($this->user, $this->password));
		}

		// Fire an event that a user was created by an admin
		if ($this->adminCreated) {
			event(new Events\UserWasCreatedByAdmin($this->user));
		}
	}
}
