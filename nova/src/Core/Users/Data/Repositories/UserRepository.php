<?php namespace Nova\Core\Users\Data\Repositories;

use Status,
	User as Model,
	UserRepositoryContract;
use Nova\Core\Users\Events;
use Nova\Foundation\Data\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryContract {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function create(array $data)
	{
		$role = (array_key_exists('role', $data)) ? (int) $data['role'] : null;

		unset($data['role']);

		// We want to make sure if this is a deleted user that we're not
		// creating lots of different user records, so if the email address
		// exists in the system already, we're retore the record
		$user = $this->model->withTrashed()->updateOrCreate(['email' => $data['email']], $data);

		if ($role)
		{
			$user->assignRole($role);
		}

		if ($user->trashed())
		{
			$user->status = Status::ACTIVE;
			$user->save();

			$user->restore();

			event(new Events\UserRestored($user));
		}
		else
		{
			event(new Events\UserCreated($user));
		}

		return $user;
	}

	public function delete($resource)
	{
		// Get the resource
		$user = $this->getResource($resource);

		if ($user)
		{
			// Deactive the user first
			$user->deactivate();

			// Remove any roles
			$user->roles()->detach();

			// Remove any user preferences
			$user->userPreferences->each(function ($preference)
			{
				$preference->delete();
			});

			if ($user->canBeDeleted())
			{
				$user->forceDelete();
			}
			else
			{
				$user->delete();
			}

			event(new Events\UserDeleted($user->id, $user->name, $user->email));

			return $user;
		}

		return false;
	}

	public function resetPassword($resource)
	{
		// Get the resource
		$user = $this->getResource($resource);

		if ($user)
		{
			$user->fill(['password' => null])->save();

			return $user;
		}

		return false;
	}
}
