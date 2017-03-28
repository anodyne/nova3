<?php namespace Nova\Api\V1\Transformers;

use Permission as Resource;
use League\Fractal\TransformerAbstract as Transformer;

class PermissionTransformer extends Transformer
{
	public function transform(Resource $resource)
	{
		$permission = [
			'id'			=> (int) $resource->id,
			'key'			=> $resource->key,
			'name'			=> $resource->name,
			'description'	=> $resource->description,
			'isProtected'	=> (bool) $resource->protected,
			'roles'			=> (array) $resource->roles->toArray(),
			'links'			=> [
				'edit'			=> route('admin.access.permissions.edit', [$resource->id]),
			],
		];

		return $permission;
	}
}
