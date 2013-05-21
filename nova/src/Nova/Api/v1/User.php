<?php namespace Nova\Api\V1;

use Status;
use Response;
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
	 * @return	Collection
	 * @todo	Parameters for getting other sets of data from the API
	 * @todo	Pagination
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

			foreach ($users as $user)
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

				$userData[] = [
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
	 * Create a new user.
	 *
	 * @return	User
	 */
	public function store()
	{
		$user = new UserModel;
		$user->user_id = Auth::user()->id;
		$user->title = Request::get('title');
		$user->content = Request::get('content');

		$user->save();

		return Response::resourceJson($user, [], 201);
	}

	/**
	 * Show a specific user.
	 *
	 * @param	int		The ID
	 * @return	User
	 */
	public function show($id)
	{
		$user = UserModel::find($id);

		if ($user !== null)
		{
			// Set the resource name
			$user->setResourceName('user');

			// Get the ETags
			$etag = Request::getEtags();

			if (isset($etag[0]))
			{
				$etag = str_replace('"', '', $etag[0]);

				if ($etag === $user->getEtag())
				{
					App::abort(304);
				}
			}

			return Response::resourceJson($user);
		}

		return Response::json(['error' => true, 'message' => 'User not found'], 404);
	}

	/**
	 * Update a user.
	 *
	 * @param	int		The ID
	 * @return	User
	 */
	public function update($id)
	{
		// Find the user
		$user = UserModel::find($id);

		// If no article return a bad request because user ID is invalid
		if ( ! $user)
		{
			App::abort(400);
		}

		// Check If-Match header
		$etag = Request::header('if-match');

		// If etag is given, and does not match
		if ($etag !== null and $etag !== $user->getEtag())
		{
			return Response::json([], 412);
		}

		// Some validation, only update fields that are present
		if (Request::get('title'))
		{
			$user->title = Request::get('title');
		}

		if (Request::get('content'))
		{
			$user->content = Request::get('content');
		}

		// Save it
		$user->save();

		// Refresh the eTag, since it'll be new
		$user->getEtag(true);

		return Response::resourceJson($user, [], 200);
	}

	/**
	 * Remove a user.
	 *
	 * @param	int		The ID
	 * @return	bool
	 */
	public function destroy($id)
	{
		$user = UserModel::find($id);

		$user->delete();

		return Response::json(['message' => 'User deleted'], 200);
	}

}