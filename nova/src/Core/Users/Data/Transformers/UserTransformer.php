<?php namespace Nova\Core\Users\Data\Transformers;

use Status;
use User as Resource;
use League\Fractal\TransformerAbstract as Transformer;

class UserTransformer extends Transformer
{
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
				//'application'	=> route('admin.users.edit', [$resource->id]),
				'edit'			=> route('admin.users.edit', [$resource->id]),
			],
			'characters'	=> $resource->characters->toArray(),
		];

		return $user;
	}
}
