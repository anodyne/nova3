<?php namespace Nova\Api\V1\Transformers;

use Status,
	UserModel as User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract {

	public function transform(User $user)
	{
		return [
			'id'		=> (int) $user->id,
			'name'		=> (string) $user->name,
			'email'		=> (string) $user->email,
			'status'	=> (string) Status::toString($user->status),
			'role'		=> (string) $user->role->name,

			'dates' => [
				'last_post'		=> (string) $user->last_post->toDateTimeString(),
				'last_login'	=> (string) $user->last_login->toDateTimeString(),
				'activated_at'	=> (string) $user->activated_at->toDateTimeString(),
				'created_at'	=> (string) $user->created_at->toDateTimeString(),
				'updated_at'	=> (string) $user->updated_at->toDateTimeString(),
			],
		];
	}

}