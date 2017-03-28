<?php namespace Nova\Api\V1\Controllers;

use PermissionRepositoryContract;
use Nova\Api\V1\Transformers\PermissionTransformer;

class PermissionApiController extends ApiBaseController
{
	protected $repo;

	public function __construct(PermissionRepositoryContract $repo)
	{
		$this->repo = $repo;
	}

	public function all()
	{
		return $this->response->collection($this->repo->all(), new PermissionTransformer);
	}

	public function show($permissionId)
	{
		$permission = $this->repo->getById($permissionId);

		if (! $permission) {
			return $this->response->errorNotFound('Permission not found');
		}

		return $this->response->item($permission, new PermissionTransformer);
	}
}
