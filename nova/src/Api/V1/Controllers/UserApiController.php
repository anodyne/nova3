<?php namespace Nova\Api\V1\Controllers;

use UserRepositoryContract;
use Nova\Api\V1\Transformers\UserTransformer;

class UserApiController extends ApiBaseController {

	protected $repo;

	public function __construct(UserRepositoryContract $repo)
	{
		$this->repo = $repo;

		$this->middleware('auth:api');
	}

	public function all()
	{
		return $this->response->collection($this->repo->all(), new UserTransformer);
	}

	public function show($userId)
	{
		$user = $this->repo->getById($userId);

		if ( ! $user)
		{
			return $this->response->errorNotFound('User not found');
		}

		return $this->response->item($user, new UserTransformer);
	}

}
