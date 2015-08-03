<?php namespace Nova\Core\Access\Data\Transformers;

use Permission;
use League\Fractal;

class PermissionTransformer extends Fractal\TransformerAbstract {

	public function transform(Permission $permission)
	{
		return [
			'id'			=> (int) $permission->id,
			'name'			=> $permission->name,
			'display_name'	=> $permission->display_name,
			'description'	=> $permission->description,
			'protected'		=> (bool) $permission->protected,
			'roles'			=> $permission->present()->rolesAsLabels,
			'links'			=> [
				'edit'			=> route('admin.access.permissions.edit', [$permission->id]),
			],
		];
	}

}
