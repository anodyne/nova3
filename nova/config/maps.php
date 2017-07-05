<?php

return [
	'creators' => [
		Nova\Authorize\Permission::class => Nova\Authorize\PermissionCreator::class,
		Nova\Authorize\Role::class => Nova\Authorize\RoleCreator::class,
		Nova\Users\User::class => Nova\Users\UserCreator::class,
	],

	'policies' => [
		Nova\Authorize\Permission::class => Nova\Authorize\Policies\PermissionPolicy::class,
		Nova\Authorize\Role::class => Nova\Authorize\Policies\RolePolicy::class,
		Nova\Users\User::class => Nova\Users\Policies\UserPolicy::class,
	],

	'repositories' => [
		Nova\Authorize\Repositories\PermissionRepositoryContract::class => Nova\Authorize\Repositories\PermissionRepository::class,
		Nova\Authorize\Repositories\RoleRepositoryContract::class => Nova\Authorize\Repositories\RoleRepository::class,
		Nova\Users\UserRepositoryContract::class => Nova\Users\UserRepository::class,
	],

	'updaters' => [
		Nova\Authorize\Permission::class => Nova\Authorize\PermissionUpdater::class,
		Nova\Authorize\Role::class => Nova\Authorize\RoleUpdater::class,
		Nova\Users\User::class => Nova\Users\UserUpdater::class,
	],
];
