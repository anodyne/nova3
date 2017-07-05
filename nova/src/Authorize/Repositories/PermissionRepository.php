<?php namespace Nova\Authorize\Repositories;

use Nova\Authorize\Permission;
use Nova\Foundation\Repositories\BaseRepository;

class PermissionRepository extends BaseRepository implements PermissionRepositoryContract
{
	public function __construct(Permission $model)
	{
		$this->model = $model;
	}

	public function delete($resource)
	{
		$resource = $this->getResource($resource);

		$resource->roles()->sync([]);

		$resource->delete();

		return $resource;
	}
}
