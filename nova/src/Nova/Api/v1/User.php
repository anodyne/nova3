<?php namespace Nova\Api\V1;

use App;
use Request;
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
	 */
	public function index($type = 'active')
	{
		switch ($type)
		{
			case 'active':
			default:
				$users = UserModel::active()->get();
			break;

			case 'inactive':
				$users = UserModel::inactive()->get();
			break;

			case 'pending':
				$users = UserModel::pending()->get();
			break;
		}

		// Set the collection name
		$users->setCollectionName('users');

		// Get the ETags from the request
		$etag = Request::getEtags();

		// If there's an ETag, check it against what we have already
		if (isset($etag[0]))
		{
			$etag = str_replace('"', '', $etag[0]);

			// Kill the request if it's the same content
			if ($etag === $users->getEtags())
			{
				App::abort(304);
			}
		}

		return Response::collectionJson($users);
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