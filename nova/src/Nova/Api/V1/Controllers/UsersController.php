<?php namespace Nova\Api\V1\Controllers;

use Status,
	UserRepositoryInterface;
use League\Fractal\Manager;
use Nova\Api\V1\Transformers\UserTransformer;

class UsersController extends BaseController {

	protected $user;

	public function __construct(Manager $fractal, UserRepositoryInterface $user)
	{
		parent::__construct($fractal);

		$this->user = $user;

		// Authenticate for every method
	}

	public function index($status = 'active')
	{
		$users = $this->user->findUsers(Status::toInt($status), 25, 0);

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
		$user = $this->user->find($id);

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