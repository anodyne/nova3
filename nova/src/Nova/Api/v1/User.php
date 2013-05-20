<?php namespace Nova\Api\V1;

use App;
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
	 * @return	Collection
	 * @todo	Parameters for getting other sets of data from the API
	 */
	public function index()
	{
		// Get all active users
		$users = UserModel::active()->get();

		// Set the collection name
		$users->setCollectionName('users');

		// Get the ETags from the request
		$etag = $this->request->getEtags();

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
		$article = new Article;
		$article->user_id = Auth::user()->id;
		$article->title = Request::get('title');
		$article->content = Request::get('content');

		$article->save();

		return Response::resourceJson($article, [], 201);
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

			$etag = Request::getEtags();

			if (isset($etag[0]))
			{
				$etag = str_replace('"', '', $etag[0]);

				if ($etag === $article->getEtag())
				{
					App::abort(304);
				}
			}

			return Response::resourceJson($article);
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
		// Find article
		$article = Article::find($id);

		// If no article return a bad request
		// because article id is invalid
		if( !$article )
		{
			App::abort(400);
		}

		// Check If-Match header
		$etag = Request::header('if-match');

		// If etag is given, and does not match
		if( $etag !== null && $etag !== $article->getEtag() )
		{
			return Response::json([], 412);
		}

		// Some validation, only update fields that are present
		if ( Request::get('title') )
		{
			$article->title = Request::get('title');
		}

		if ( Request::get('content') )
		{
			$article->content = Request::get('content');
		}

		// Save it
		$article->save();

		// Refresh the eTag, since it'll be new
		$article->getEtag(true);

		return Response::resourceJson($article, [], 200);
	}

	/**
	 * Remove a user.
	 *
	 * @param	int		The ID
	 * @return	bool
	 */
	public function destroy($id)
	{
		$article = Article::find($id);

		$article->delete();

		return Response::json([
			'message' => 'Article Deleted'
		], 200);
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