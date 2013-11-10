<?php namespace Nova\Api\V1;

use Input;
use Status;
use Response;
use Exception;
use UserValidator;
use UserRepositoryInterface;

class User extends Base {

	public function __construct(UserRepositoryInterface $user)
	{
		parent::__construct();

		$this->user = $user;

		//$this->beforeFilter('auth.api');
	}

	/**
	 * Display all active users.
	 *
	 * @param	string	$type	Type of users to pull (active, inactive, pending)
	 * @param	int		$page	Page number
	 * @return	JSON
	 */
	public function index($type = 'active', $page = 1)
	{
		// Get the users
		$users = $this->user->findUsers(
			Status::toInt($type),
			$this->resultsPerPage,
			($page > 1) ? ($page - 1) * $this->resultsPerPage : false
		);

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
						? $this->url."/user/{$type}/".($page + 1)
						: $this->url."/user/{$type}/{$totalPages}",
					'previous'	=> ($page > 1) 
						? $this->url."/user/{$type}/".($page - 1)
						: $this->url."/user/{$type}/1",
				],
			];
			$data['users'] = $userData;

			return Response::json($data, 200);
		}

		return Response::json(['message' => "No {$type} users found"], 404);
	}

	/**
	 * Show a specific user.
	 *
	 * @param	int		$id		User ID
	 * @return	JSON
	 */
	public function show($id)
	{
		// Get the user
		$user = $this->user->find($id);

		if ($user)
		{
			return Response::json($this->collectUserData($user), 200);
		}

		return Response::json(['message' => "User not found"], 400);
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

		try
		{
			// Create a new user
			$user = $this->user->create(Input::all(), false);

			return Response::json($this->collectUserData($user), 201);
		}
		catch (Exception $e)
		{
			return Response::json([
				'message'	=> $e->getMessage(),
				'file'		=> $e->getFile(),
				'line'		=> $e->getLine(),
			], 500);
		}
	}

	/**
	 * Update a user.
	 *
	 * @param	int		$id		User ID
	 * @return	JSON
	 * @todo	Authorization
	 * @fixme
	 */
	public function update($id)
	{
		// Find the user
		$user = $this->user->find($id);

		if ($user)
		{
			// Validate the user
			$this->validateUser();

			// Update the user
			$user = $this->user->update($id, Input::all(), false);

			return Response::json($this->collectUserData($user), 200);
		}

		return Response::json(['message' => "User not found"], 400);
	}

	/**
	 * Remove a user.
	 *
	 * @param	int		$id		User ID
	 * @return	JSON
	 * @todo	Authorization
	 */
	public function destroy($id)
	{
		// Delete the user
		$user = $this->user->delete($id, false);

		if ($user)
		{
			return Response::json(['message' => "User removed"], 200);
		}

		return Response::json(['message' => "User not found"], 400);
	}

	/**
	 * Pull all the user data together.
	 *
	 * @param	User	$user	User object
	 * @return	array
	 */
	protected function collectUserData($user)
	{
		// Get the user's primary character
		$primary = $user->getPrimaryCharacter();

		if ($primary)
		{
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
		}

		if ($user->characters->count() > 0)
		{
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
		}

		// Get the user data from the user form
		$userForm = [];

		if ($user->data->count() > 0)
		{
			// Loop through the user form and collect the data
			foreach ($user->data as $d)
			{
				if ( ! empty($d->value))
				{
					// Set the key
					$key = strtolower($d->field->label);
					$key = str_replace(' ', '_', $key);

					$userForm[$key] = $d->value;
				}
			}
		}

		// Set the data
		$data = [
			'id'				=> $user->id,
			'name'				=> $user->name,
			'email'				=> $user->email,
			'status'			=> Status::toString($user->status),
			'role'				=> $user->role->name,

			'user_data'			=> $userForm,

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
		$validator = new UserValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
		{
			// Format the validation errors
			$messages = $this->formatValidationErrors($validator);

			return Response::json([
				'message' => "Validation of the user information failed. {$messages}"
			], 409);
		}
	}

}