<?php namespace Nova\Api\V1\Controllers;

use RoleRepositoryContract;
use Nova\Api\V1\Transformers\RoleTransformer;

class RoleApiController extends ApiBaseController
{
	protected $repo;

	public function __construct(RoleRepositoryContract $repo)
	{
		$this->repo = $repo;
	}

	public function all()
	{
		return $this->response->collection($this->repo->all(), new RoleTransformer);
	}

	public function show($roleId)
	{
		$role = $this->repo->getById($roleId);

		if (! $role) {
			return $this->response->errorNotFound('Role not found');
		}

		return $this->response->item($role, new RoleTransformer);
	}
}
