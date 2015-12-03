<?php namespace Nova\Core\Access\Data\Repositories;

use Role as Model,
	RoleRepositoryInterface;
use Nova\Foundation\Data\Repositories\BaseRepository;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function all(array $with = ['permissions', 'users'])
	{
		return $this->make($with)->get();
	}

	/**
	 * We need to modify the way we create a role to allow for attaching
	 * the permissions to the role at the same time as creating the role
	 */
	public function create(array $data)
	{
		$role = parent::create($data);

		// Assign the permissions to the role
		if (array_key_exists('permissions', $data))
		{
			$role->addPermissions($data['permissions']);
		}

		return $role;
	}

	/**
	 * We need to modify the way we delete a role to allow for detaching
	 * the permissions and users from the role
	 */
	public function delete($resource)
	{
		// Get the role we're removing
		$role = $this->getResource($resource);

		if ($role)
		{
			// Remove all the permissions attached to this role
			$role->permissions()->detach();

			// Unassign all the users who have this role
			$role->users()->detach();

			$role->delete();

			return $role;
		}

		return false;
	}

	public function duplicate($resource, $newName = null, $newKey = null)
	{
		// Get the item we're duplicate from
		$originalRole = $this->getResource($resource);

		if ($originalRole)
		{
			$newRole = $originalRole->replicate();
			$newRole->display_name = ($newName) ? $newName : "Copy of ".$newRole->display_name;
			$newRole->name = ($newKey) ? $newKey : $newRole->name."-copy";
			$newRole->push();

			// Duplicate the permissions for the role
			$newRole->addPermissions($originalRole->permissions);

			return $newRole;
		}

		return false;
	}

	public function find($id)
	{
		return $this->getById($id, ['permissions']);
	}

	/**
	 * We need to modify the way we update a role to allow for attaching
	 * the permissions to the role at the same time as updating the role
	 */
	public function update($resource, array $data)
	{
		$role = parent::update($resource, $data);

		// Assign the permissions to the role
		if (array_key_exists('permissions', $data))
		{
			$role->addPermissions($data['permissions']);
		}

		return $role;
	}

}
