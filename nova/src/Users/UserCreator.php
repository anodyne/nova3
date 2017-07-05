<?php namespace Nova\Users;

use Str;
use Status;
use Nova\Foundation\Creator;
use Nova\Users\UserRepositoryContract as Repository;

class UserCreator extends Creator
{
	protected $password;
	protected $adminCreated = false;
	protected $passwordWasGenerated = false;

	public function __construct(Repository $repo)
	{
		$this->repo = $repo;
	}

	public function create()
	{
		// Make sure we set a pending status on the user
		// $this->data(['status' => Status::PENDING]);

		// Create the user
		$this->item = $this->repo->create($this->data);

		// Attach the role(s)
		$this->attachRoles();

		// Fire any events we need to
		$this->fireEvents();

		// Reset the password stuff so we don't leave it sitting out there
		$this->password = null;
		$this->passwordWasGenerated = false;

		return $this->item;
	}

	public function adminCreate()
	{
		$this->adminCreated = true;

		$this->create();

		return $this->item;
	}

	public function generatePassword()
	{
		if (! array_key_exists('password', $this->data)) {
			$this->password = Str::random(12);
			$this->passwordWasGenerated = true;
		}

		return $this;
	}

	public function attachRoles()
	{
		if (array_key_exists('roles', $this->data)) {
			$this->user->roles()->attach($this->data['roles']);
		}

		return $this;
	}

	public function fireEvents()
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
