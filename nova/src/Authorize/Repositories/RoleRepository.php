<?php namespace Nova\Authorize\Repositories;

use Nova\Authorize\Role;
use Nova\Foundation\Repositories\BaseRepository;

class RoleRepository extends BaseRepository implements RoleRepositoryContract
{
	public function __construct(Role $model)
	{
		$this->model = $model;
	}

	public function delete($resource)
	{
		$resource = $this->getResource($resource);

		$resource->removePermissions();

		$resource->delete();

		return $resource;
	}
}
