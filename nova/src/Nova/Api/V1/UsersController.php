<?php

use UserRepositoryInterface;

class UsersController extends BaseController {

	protected $user;

	public function __construct(UserRepositoryInterface $user)
	{
		parent::__construct();

		$this->user = $user;

		// Authenticate for every method
	}

	public function index($status = 'active')
	{
		//
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
			return Response::json($this->collectUserData($user), 200);
		}

		return Response::json(['message' => "User not found"], 404);
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