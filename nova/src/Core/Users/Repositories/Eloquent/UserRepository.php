<?php namespace Nova\Core\Repositories\Eloquent;

use App,
	Status,
	Session,
	UserModel,
	UtilityTrait,
	SecurityTrait,
	UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface {

	use UtilityTrait,
		SecurityTrait;

	/**
	 * Activate a user and associate a primary character for them.
	 *
	 * @param	int		$id				User ID
	 * @param	int		$characterId	Character ID
	 * @return	User
	 */
	public function activate($id, $characterId)
	{
		// Update the user
		$item = $this->update($id, ['status' => Status::ACTIVE]);

		// If the user has characters, activate them
		if ($item->characters->count() > 0)
		{
			foreach ($item->characters as $character)
			{
				if ($character->status == Status::INACTIVE)
				{
					$character->update(['status' => Status::ACTIVE]);
				}
			}
		}

		return $item;
	}
	
	/**
	 * Get all active users.
	 *
	 * @return	Collection
	 */
	public function active()
	{
		return UserModel::active()->get();
	}

	/**
	 * Get everything out of the database.
	 *
	 * @return	Collection
	 */
	public function all()
	{
		return UserModel::all();
	}
	
	/**
	 * Create a new item.
	 *
	 * @param	array	$data	Data to use for creation
	 * @return	User
	 */
	public function create(array $data, $setFlash = true)
	{
		$user = UserModel::create($data);

		if ($setFlash)
		{
			$flashStatus = ($user) ? 'success' : 'danger';
			$flashMessage = ($user) 
				? lang('Short.alert.success.create', lang('user'))
				: lang('Short.alert.failure.create', lang('user'));

			$this->setFlashMessage($flashStatus, $flashMessage);
		}

		return $user;
	}

	/**
	 * Deactivate a user.
	 *
	 * @param	int		$id		User ID
	 * @return	User
	 */
	public function deactivate($id)
	{
		// Update the user record
		$item = $this->update($id, ['status' => Status::INACTIVE]);

		// If the user has characters, deactivate them
		if ($item->characters->count() > 0)
		{
			foreach ($item->characters as $character)
			{
				if ($character->status == Status::ACTIVE)
				{
					$character->update(['status' => Status::INACTIVE]);
				}
			}
		}

		return $item;
	}

	/**
	 * Delete an item.
	 *
	 * @param	int		$id		ID to delete
	 * @return	User
	 */
	public function delete($id, $setFlash = true)
	{
		// Get the user
		$user = $this->find($id);

		if ($user)
		{
			$delete = $user->deleteUser();

			if ($setFlash)
			{
				// Set the flash info
				$flashStatus = ($user) ? 'success' : 'danger';
				$flashMessage = ($user) 
					? lang('Short.alert.success.delete', lang('user'))
					: lang('Short.alert.failure.delete', lang('user'));

				$this->setFlashMessage($flashStatus, $flashMessage);
			}

			return $user;
		}

		return false;
	}

	/**
	 * Find an item by ID.
	 *
	 * @param	int		$id		ID to find
	 * @return	User
	 */
	public function find($id)
	{
		return UserModel::find($this->sanitizeInt($id));
	}

	/**
	 * Find a user by their email address.
	 *
	 * @param	string	$email	Email to find
	 * @return	User
	 */
	public function findByEmail($email)
	{
		return UserModel::email($this->sanitizeString($email))->first();
	}

	/**
	 * Find a user by their name.
	 *
	 * @param	string	$name	Name to find
	 * @return	Collection
	 */
	public function findByName($name)
	{
		return UserModel::searchName($this->sanitizeString($name))->get();
	}

	/**
	 * Find users by a status with a limit and offset.
	 *
	 * @param	int		$status		User status
	 * @param	int		$limit		How many users to get back
	 * @param	int		$offset		The offset of users
	 * @param	Collection
	 */
	public function findUsers($status, $limit, $offset)
	{
		$items = UserModel::where('status', $status);

		if ($limit)
		{
			$items = $items->take($limit);
		}

		if ($offset)
		{
			$items = $items->skip($offset);
		}

		return $items->get();
	}

	/**
	 * Get all inactive users.
	 *
	 * @return	Collection
	 */
	public function inactive()
	{
		return UserModel::inactive()->get();
	}

	/**
	 * Get all pending users.
	 *
	 * @return	Collection
	 */
	public function pending()
	{
		return UserModel::pending()->get();
	}

	/**
	 * Update an item.
	 *
	 * @param	int		$id		ID to update
	 * @param	array	$data	Data to use for update
	 * @return	User
	 */
	public function update($id, array $data, $setFlash = true)
	{
		// Get the user
		$user = $this->find($id);

		if ($user)
		{
			// Get the type of update we're making
			$formAction = $data['formAction'];

			if ($formAction == 'basic')
			{
				if (array_key_exists('password', $data))
				{
					// Do the update
					$item = $user->update($data);

					$flashStatus = 'success';
					$flashMessage = lang('Short.alert.success.update', lang('user'));
				}
				else
				{
					// Make sure their current password is right
					if (App::make('sentry.hasher')->hash($data['password']) == $user->password)
					{
						// Make sure the new password matches the confirmation
						if ($data['password_new'] == $data['password_new_confirm'])
							$item = $user->update(array_merge($data, ['password' => $data['password_new']]));
						
						else
						{
							$flashStatus = 'danger';
							$flashMessage = lang('error.admin.user.passwordsNotMatching');
						}
					}
					else
					{
						$flashStatus = 'danger';
						$flashMessage = lang('error.admin.user.wrongPassword');
					}
				}
			}

			if ($formAction == 'bio' or $formAction == 'preferences' or $formAction == 'notifications')
			{
				// Do the update
				switch ($formAction)
				{
					case 'bio':
						$item = $this->updateFormData($user->id, $data);

						$text = 'user bio';
					break;

					case 'preferences':
					case 'notifications':
						$item = $this->updatePreferences($user->id, $data);

						if ($formAction == 'preferences')
							$text = 'user preferences';

						if ($formAction == 'notifications')
							$text = 'user notification preferences';
					break;
				}

				// Set the flash info
				$flashStatus = ($item) ? 'success' : 'danger';
				$flashMessage = ($item) 
					? lang('Short.alert.success.update', langConcat($text))
					: lang('Short.alert.failure.update', langConcat($text));
			}

			if ($formAction == 'admin')
			{
				// Moderation

				// Change access level

				// Is system admin

				// Is game master
			}

			if ($setFlash)
			{
				// Set the flash message
				$this->setFlashMessage($flashStatus, $flashMessage);
			}

			return $user;
		}

		return false;
	}

	/**
	 * Update the user form data.
	 *
	 * @param	int		$id		The user being updated
	 * @param	array	$data	Data used in the update
	 * @return	bool
	 */
	public function updateFormData($id, array $data)
	{
		// Get the user
		$user = $this->find($id);

		if ($user)
		{
			foreach ($user->data as $formData)
			{
				// Make sure the data array has this item
				if (array_key_exists($formData->field_id, $data))
				{
					// Update the record
					$formData->update(['value' => $data[$formData->field_id]]);
				}
			}

			return true;
		}

		return false;
	}

	/**
	 * Update the user's preferences.
	 *
	 * @param	int		$id		The user being updated
	 * @param	array	$data	Data used in the update
	 * @return	bool
	 */
	public function updatePreferences($id, array $data)
	{
		// Get the user
		$user = $this->find($id);

		if ($user)
		{
			foreach ($user->preferences as $pref)
			{
				// Make sure the data array has this item
				if (array_key_exists($pref->key, $data))
				{
					// Update the record
					$pref->update(['value' => $data[$pref->key]]);
				}
			}

			return true;
		}

		return false;
	}

}