<?php namespace Nova\Api\V1\Transformers;

use Role as Resource;
use League\Fractal\TransformerAbstract as Transformer;

class RoleTransformer extends Transformer {

	public function transform(Resource $resource)
	{
		return [
			'id'			=> (int) $resource->id,
			'key'			=> $resource->key,
			'name'			=> $resource->name,
			'description'	=> $resource->description,
			'permissions'	=> (array) $resource->permissions->toArray(),
			'links'			=> [
				'edit'			=> route('admin.access.roles.edit', [$resource->id]),
			],
		];
	}

}
