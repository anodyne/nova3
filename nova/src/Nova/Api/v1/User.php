<?php namespace Nova\Api\V1;

use Input;
use Status;
use Response;
use UserValidator;
use User as UserModel;

class User extends Base {

	public function __construct()
	{
		parent::__construct();

		//$this->beforeFilter('api.auth');
	}

	/**
	 * Display all active users.
	 *
	 * @param	string		Type of users to pull (active, inactive, pending)
	 * @param	int			Page number
	 * @return	JSON
	 */
	public function index($type = 'active', $page = 1)
	{
		// Start getting the users
		switch ($type)
		{
			case 'active':
			default:
				$items = UserModel::active();
			break;

			case 'inactive':
				$items = UserModel::inactive();
			break;

			case 'pending':
				$items = UserModel::pending();
			break;
		}

		// Set up the paging
		if ($page > 1) $items->skip(--$page * $this->resultsPerPage);
		$items->take($this->resultsPerPage);

		// Execute the query
		$users = $items->get();

		// Loop through the users and put them into an array
		if ($users->count() > 0)
		{
			// Holding array for the user data
			$userData = [];

			// Loop through the users and collect the data
			foreach ($users as $user)
			{
				$userData[] = $this->collectUserData($user);
			}

			// Set the data
			$totalPages = ceil($users->count()/$this->resultsPerPage);
			$data['_meta'] = [
				'page'			=> $page,
				'per_page'		=> $this->resultsPerPage,
				'page_count'	=> $totalPages,
				'total_count'	=> $users->count(),
				'links'			=> [
					'self'		=> $this->url."/user/{$type}/{$page}",
					'first'		=> $this->url."/user/{$type}/{$totalPages}",
					'last'		=> $this->url."/user/{$type}/{$page}",
					'next'		=> ($page < $totalPages)
						? $this->url."/user/{$type}/".(++$page)
						: $this->url."/user/{$type}/{$totalPages}",
					'previous'	=> ($page > 1) 
						? $this->url."/user/{$type}/".(--$page)
						: $this->url."/user/{$type}/1",
				],
			];
			$data['users'] = $userData;

			return Response::api($data, 200);
		}

		return Response::api("No {$type} users found", 404);
	}

	/**
	 * Show a specific user.
	 *
	 * @param	int		The user ID
	 * @return	JSON
	 */
	public function show($id)
	{
		// Get the user
		$user = UserModel::find($id);

		if ($user !== null)
		{
			return Response::api($this->collectUserData($user), 200);
		}

		return Response::api("User not found", 400);
	}

	/**
	 * Create a new user.
	 *
	 * @return	JSON
	 * @todo	Authorization
	 */
	public function store()
	{
		// Validate the user
		$this->validateUser();

		// Create a new user
		$user = UserModel::add(Input::get(), true);

		return Response::api($this->collectUserData($user), 201);
	}

	/**
	 * Update a user.
	 *
	 * @param	int		The user ID
	 * @return	JSON
	 * @todo	Authorization
	 */
	public function update($id)
	{
		// Find the user
		$user = UserModel::find($id);

		// If no article return a bad request because user ID is invalid
		if ($user !== null)
		{
			// Validate the user
			$this->validateUser();

			// Update the user
			$user->update(Input::get());

			return Response::api($this->collectUserData($user), 200);
		}

		return Response::api("User not found", 400);
	}

	/**
	 * Remove a user.
	 *
	 * @param	int		The ID
	 * @return	JSON
	 * @todo	Authorization
	 */
	public function destroy($id)
	{
		// Find the user
		$user = UserModel::find($id);

		if ($user !== null)
		{
			$user->delete();

			return Response::api("User removed", 200);
		}

		return Response::api("User not found", 400);
	}

	/**
	 * Pull all the user data together.
	 *
	 * @param	User	The user
	 * @return	array
	 */
	protected function collectUserData($user)
	{
		// Get the user's primary character
		$primary = $user->getPrimaryCharacter();

		// Get the primary character's positions
		foreach ($primary->positions as $position)
		{
			$primaryCharacterPositions[] = [
				'id'			=> $position->id,
				'name'			=> $position->name,
				'department'	=> $position->dept->name,
				'primary'		=> (bool) $position->pivot->primary,
			];

			if ((bool) $position->pivot->primary === true)
			{
				$primaryCharacterPrimaryPosition = [
					'id'			=> $position->id,
					'name'			=> $position->name,
					'department'	=> $position->dept->name,
				];
			}
		}

		// Get the user's characters
		foreach ($user->characters as $char)
		{
			// Get the primary character's positions
			foreach ($char->positions as $position)
			{
				$characterPositions[] = [
					'id'			=> $position->id,
					'name'			=> $position->name,
					'department'	=> $position->dept->name,
					'primary'		=> (bool) $position->pivot->primary,
				];

				if ((bool) $position->pivot->primary === true)
				{
					$characterPrimaryPosition = [
						'id'			=> $position->id,
						'name'			=> $position->name,
						'department'	=> $position->dept->name,
					];
				}
			}

			$userCharacters[] = [
				'id'			=> $char->id,
				'name'			=> $char->getName(),
				'rank'			=> $char->rank->info->name,
				'position'		=> $characterPrimaryPosition,
				'all_positions'	=> $characterPositions,
			];
		}

		// Set the data
		$data = [
			'id'				=> $user->id,
			'name'				=> $user->name,
			'email'				=> $user->email,
			'status'			=> Status::toString($user->status),
			'role'				=> $user->role->name,

			'dates'				=> [
				'last_post'		=> $user->last_post->toDateTimeString(),
				'last_login'	=> $user->last_login->toDateTimeString(),
				'activated_at'	=> $user->activated_at->toDateTimeString(),
				'created_at'	=> $user->created_at->toDateTimeString(),
				'updated_at'	=> $user->updated_at->toDateTimeString(),
			],
			
			'primary_character'	=> [
				'id'			=> $primary->id,
				'name'			=> $primary->getName(),
				'rank'			=> $primary->rank->info->name,
				'position'		=> $primaryCharacterPrimaryPosition,
				'all_positions'	=> $primaryCharacterPositions,
			],
			
			'characters'		=> $userCharacters,
		];

		return $data;
	}

	/**
	 * Validate the user.
	 *
	 * @return	Response|void
	 */
	protected function validateUser()
	{
		// Set up the validation service
		$validator = new UserValidator(Input::get());

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
		{
			// Format the validation errors
			$messages = $this->formatValidationErrors($validator);

			return Response::api("Validation of the user information failed. {$messages}", 409);
		}
	}

}