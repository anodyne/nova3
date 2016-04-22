<?php namespace Nova\Core\Access\Data\Repositories;

use Permission as Model,
	PermissionRepositoryContract;
use Illuminate\Support\Collection;
use Nova\Core\Access\Events;
use Nova\Foundation\Data\Repositories\BaseRepository;

class PermissionRepository extends BaseRepository implements PermissionRepositoryContract {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function allByComponent()
	{
		// Get all the permissions
		$permissions = $this->all();

		if ($permissions)
		{
			foreach ($permissions as $permission)
			{
				// Get the component and action out of the key
				list($component, $action) = explode('.', $permission->name);

				// Capitalize the component
				$component = ucwords($component);

				// Store the permission
				$permissionsList[$component][$action] = $permission;

				// Sort the array by the actions
				ksort($permissionsList[$component]);
			}

			// Sort by the component
			ksort($permissionsList);

			return $permissionsList;
		}

		return [];
	}

	public function create(array $data)
	{
		$permission = parent::create($data);

		event(new Events\PermissionCreated($permission));

		return $permission;
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

			event(new Events\PermissionDeleted($permission->name, $permission->display_name));

			return $permission;
		}

		return false;
	}

	public function find($id)
	{
		return $this->getById($id, ['roles']);
	}

	public function update($resource, array $data)
	{
		$permission = parent::update($resource, $data);

		event(new Events\PermissionUpdated($permission));

		return $permission;
	}

}
