<?php namespace Nova\Core\Access\Data\Repositories;

use Permission as Model,
	PermissionRepositoryInterface;
use Nova\Foundation\Data\Repositories\BaseRepository;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	/**
	 * We need to modify the way we delete a permission to allow for detaching
	 * the permission being removed from any role(s) it's attached to
	 */
	public function delete($resource)
	{
		// Get the permission
		$permission = $this->getResource($resource);

		if ($permission)
		{
			// Detach from any roles
			$permission->roles()->detach();

			// Delete the permission
			$permission->delete();

			return $permission;
		}

		return false;
	}

	public function find($id)
	{
		return $this->getById($id, ['roles']);
	}

}
