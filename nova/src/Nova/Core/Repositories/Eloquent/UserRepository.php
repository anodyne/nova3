<?php namespace Nova\Core\Repositories\Eloquent;

use Status;
use UserModel;
use SecurityTrait;
use UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface {

	use SecurityTrait;

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

		# TODO: activate the character

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
	public function create(array $data)
	{
		return UserModel::create($data);
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
					$character->update(['status' => Status::INACTIVE]);
			}
		}

		return $item;
	}

	/**
	 * Delete an item.
	 *
	 * @param	int		$id		ID to delete
	 * @return	bool
	 */
	public function delete($id)
	{
		$id = $this->sanitizeInt($id);

		// Get the user
		$item = $this->find($id);

		if ($item)
			return $item->deleteUser();

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
		$id = $this->sanitizeInt($id);

		return UserModel::find($id);
	}

	/**
	 * Find a user by their email address.
	 *
	 * @param	string	$email	Email to find
	 * @return	User
	 */
	public function findByEmail($email)
	{
		$email = $this->sanitizeString($email);

		return UserModel::email($email)->first();
	}

	/**
	 * Find a user by their name.
	 *
	 * @param	string	$name	Name to find
	 * @return	Collection
	 */
	public function findByName($name)
	{
		$name = $this->sanitizeString($name);

		return UserModel::searchName($name)->get();
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
	public function update($id, array $data)
	{
		$id = $this->sanitizeInt($id);
		
		// Get the user
		$item = $this->find($id);

		if ($item)
			return $item->update($data);

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