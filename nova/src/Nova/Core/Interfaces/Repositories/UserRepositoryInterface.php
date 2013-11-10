<?php namespace Nova\Core\Interfaces\Repositories;

use BaseRepositoryInterface;

interface UserRepositoryInterface extends BaseRepositoryInterface {

	/**
	 * Activate a user and associate a primary character for them.
	 *
	 * @param	int		$id				User ID
	 * @param	int		$characterId	Character ID
	 * @return	User
	 */
	public function activate($id, $characterId);

	/**
	 * Get all active users.
	 *
	 * @return	Collection
	 */
	public function active();

	/**
	 * Deactivate a user.
	 *
	 * @param	int		$id		User ID
	 * @return	User
	 */
	public function deactivate($id);

	/**
	 * Find a user by their email address.
	 *
	 * @param	string	$email	Email to find
	 * @return	User
	 */
	public function findByEmail($email);

	/**
	 * Find a user by their name.
	 *
	 * @param	string	$name	Name to find
	 * @return	Collection
	 */
	public function findByName($name);

	/**
	 * Find users by a status with a limit and offset.
	 *
	 * @param	int		$status		User status
	 * @param	int		$limit		How many users to get back
	 * @param	int		$offset		The offset of users
	 * @param	Collection
	 */
	public function findUsers($status, $limit, $offset);

	/**
	 * Get all inactive users.
	 *
	 * @return	Collection
	 */
	public function inactive();

	/**
	 * Get all pending users.
	 *
	 * @return	Collection
	 */
	public function pending();

	/**
	 * Update the user form data.
	 *
	 * @param	int		$id		The user being updated
	 * @param	array	$data	Data used in the update
	 * @return	bool
	 */
	public function updateFormData($id, array $data);

	/**
	 * Update the user's preferences.
	 *
	 * @param	int		$id		The user being updated
	 * @param	array	$data	Data used in the update
	 * @return	bool
	 */
	public function updatePreferences($id, array $data);

}