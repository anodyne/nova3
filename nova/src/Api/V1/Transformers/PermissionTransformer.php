<?php namespace Nova\Api\V1\Transformers;

use Permission as Resource;
use League\Fractal\TransformerAbstract as Transformer;

class PermissionTransformer extends Transformer {

	public function transform(Resource $resource)
	{
		return [
			'id'			=> (int) $resource->id,
			'name'			=> $resource->name,
			'display_name'	=> $resource->display_name,
			'description'	=> $resource->description,
			'protected'		=> (bool) $resource->protected,
			'roles'			=> $resource->present()->rolesAsLabels,
			'links'			=> [
				'edit'			=> route('admin.access.permissions.edit', [$resource->id]),
			],
		];
	}

}
