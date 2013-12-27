<?php namespace Nova\Api\V1\Controllers;

use Status,
	UserModel;
use League\Fractal\Manager;
use Nova\Api\V1\Transformers\UserTransformer;

class UsersController extends BaseController {

	public function __construct(Manager $fractal)
	{
		parent::__construct($fractal);

		// Authenticate for every method

		// Set the possible relationships for a user
		$possibleRelationships = [
			'characters'	=> 'character',
			'announcements'	=> 'announcement',
			'posts'			=> 'post',
			'logs'			=> 'log',
		];

		// Set the items to eager load
		$this->eagerLoad = array_values(array_intersect(
			$possibleRelationships,
			$this->requestedEmbeds
		));
	}

	public function index($status = 'active')
	{
		$users = UserModel::with($this->eagerLoad)->get();

		if ($users)
		{
			return $this->respondWithCollection($users, new UserTransformer);
		}

		return $this->errorNotFound('No users found');
	}

	public function store()
	{
		//
	}

	public function show($id)
	{
		// Get the user
		$user = UserModel::find($id);

		if ($user)
		{
			return $this->respondWithItem($user, new UserTransformer);
		}

		return $this->errorNotFound('User not found');
	}

	public function showCharacters($id)
	{
		//
	}

	public function showImage($id)
	{
		//
	}

	public function update($id)
	{
		//
	}

	public function destroy($id)
	{
		//
	}

}