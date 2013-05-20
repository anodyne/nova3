<?php namespace Nova\Api\Controller\V1;

use Response;
use User as UserModel;
use Nova\Api\Controller\Base\Api as ApiBaseController;

class User extends ApiBaseController {

	public function __construct()
	{
		$this->beforeFilter('apiAuth');
	}

	/**
	 * Display all active users.
	 *
	 * @return	Collection
	 */
	public function index()
	{
		return UserModel::active()->get();
	}

	/**
	 * Create a new user.
	 *
	 * @return	User
	 */
	public function store()
	{
		//
	}

	/**
	 * Show a specific user.
	 *
	 * @param	int		The ID
	 * @return	User
	 */
	public function show($id)
	{
		if (is_numeric($id))
		{
			$user = UserModel::find($id);

			if ($user !== null) return $user;
			
			return Response::json(['error' => true, 'message' => 'User not found'], 404);
		}

		return Response::json(['error' => true, 'message' => 'Invalid user ID'], 404);
	}

	/**
	 * Update a user.
	 *
	 * @param	int		The ID
	 * @return	User
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove a user.
	 *
	 * @param	int		The ID
	 * @return	bool
	 */
	public function destroy($id)
	{
		//
	}

	/**
	 * Show the user creation form.
	 *
	 * @return	501
	 */
	public function create()
	{
		return Response::json(['error' => true, 'message' => 'Method not available'], 501);
	}

	/**
	 * Show the user edit form.
	 *
	 * @return	501
	 */
	public function edit($id)
	{
		return Response::json(['error' => true, 'message' => 'Method not available'], 501);
	}

}