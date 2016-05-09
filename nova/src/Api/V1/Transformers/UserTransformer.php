<?php namespace Nova\Api\V1\Transformers;

use Status,
	User as Resource;
use League\Fractal\TransformerAbstract as Transformer;

class UserTransformer extends Transformer {

	public function transform(Resource $resource)
	{
		$user = [
			'id'			=> (int) $resource->id,
			'name'			=> $resource->name,
			'nickname'		=> $resource->nickname,
			'displayName'	=> $resource->present()->name,
			'email'			=> $resource->email,
			'status'		=> Status::toString($resource->status),
			'links'			=> [
				'edit'			=> route('admin.users.edit', [$resource->id]),
			],
			'characters'	=> $resource->characters->toArray(),
		];

		return $user;
	}

}
