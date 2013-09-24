<?php namespace Nova\Core\Repositories\Eloquent;

use User;
use SecurityTrait;
use UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface {

	use SecurityTrait;

	/*
	|--------------------------------------------------------------------------
	| BaseRepositoryInterface Implementation
	|--------------------------------------------------------------------------
	*/
	
	public function all()
	{
		return User::all();
	}
	
	public function create(array $data)
	{
		return User::create($data);
	}

	public function delete($id)
	{
		$id = $this->sanitizeInt($id);

		// Get the user
		$item = $this->find($id);

		if ($item)
			return $item->deleteUser();

		return false;
	}

	public function find($id)
	{
		$id = $this->sanitizeInt($id);

		return User::find($id);
	}

	public function update($id, array $data)
	{
		$id = $this->sanitizeInt($id);
		
		// Get the user
		$item = $this->find($id);

		if ($item)
			return $item->update($data);

		return false;
	}

	/*
	|--------------------------------------------------------------------------
	| UserRepositoryInterface Implementation
	|--------------------------------------------------------------------------
	*/

	/**
	 * Get all active users.
	 *
	 * @return	Collection
	 */
	public function active()
	{
		return User::active()->get();
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

		return User::email($email)->first();
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

		return User::searchName($name)->get();
	}

	/**
	 * Get all inactive users.
	 *
	 * @return	Collection
	 */
	public function inactive()
	{
		return User::inactive()->get();
	}

	/**
	 * Get all pending users.
	 *
	 * @return	Collection
	 */
	public function pending()
	{
		return User::pending()->get();
	}

}