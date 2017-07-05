<?php namespace Nova\Users;

use Str;
use Nova\Users\Events;
use Nova\Foundation\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryContract
{
	public function __construct(User $model)
	{
		$this->model = $model;
	}

	public function all(array $with = [], $trashed = false)
	{
		$entity = $this->make($with);

		if ($trashed) {
			$entity = $entity->withTrashed();
		}

		return $entity->get();
	}

	public function create(array $attributes = [])
	{
		$passwordWasGenerated = false;

		// We don't have a password, so we need to generate one
		if (! array_key_exists('password', $attributes)) {
			$password = $attributes['password'] = Str::random(12);

			$passwordWasGenerated = true;
		}

		// Create the user
		$user = User::create($attributes);

		// Handle the roles if we have them
		if (array_key_exists('roles', $attributes)) {
			$user->roles()->sync($attributes['roles']);
		}

		// Notify the user of their password
		if ($passwordWasGenerated) {
			event(new Events\PasswordWasGenerated($user, $password));
		}

		// Fire an event that a user was created by an admin
		event(new Events\UserWasCreatedByAdmin($user));

		return $user;
	}

	public function delete($resource)
	{
		// Find the resource
		$resource = $this->getResource($resource);

		// Delete the resource
		$resource->delete();

		// Fire an event that the user was deleted by an admin
		event(new Events\UserWasDeletedByAdmin($resource->name, $resource->email));

		return true;
	}

	public function restore($resource)
	{
		// Find the resource
		$resource = $this->getResource($resource);

		// Update the resource
		$resource->restore();

		// Generate a new password for the user
		$password = Str::random(12);

		// Update the password for the user
		$this->update($resource, ['password' => $password]);

		// Fire events for a new password and the user being restored by an admin
		event(new Events\UserWasRestoredByAdmin($resource));
		event(new Events\PasswordWasGenerated($resource, $password));

		return $resource;
	}

	public function update($resource, array $attributes)
	{
		// Find the resource
		$resource = $this->getResource($resource);

		// Update the resource
		$resource->update($attributes);

		// Fire an event that the user was deleted by an admin
		event(new Events\UserWasUpdatedByAdmin($resource));

		return $resource;
	}
}
