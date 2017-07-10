<?php

return [
	'creators' => [
		Nova\Authorize\Permission::class => Nova\Authorize\Data\PermissionCreator::class,
		Nova\Authorize\Role::class => Nova\Authorize\Data\RoleCreator::class,
		Nova\Genres\Department::class => Nova\Genres\Data\DepartmentCreator::class,
		Nova\Users\User::class => Nova\Users\Data\UserCreator::class,
	],

	'deletors' => [
		Nova\Authorize\Permission::class => Nova\Authorize\Data\PermissionDeletor::class,
		Nova\Authorize\Role::class => Nova\Authorize\Data\RoleDeletor::class,
		Nova\Genres\Department::class => Nova\Genres\Data\DepartmentDeletor::class,
		Nova\Users\User::class => Nova\Users\Data\UserDeletor::class,
	],

	'events' => [
		Nova\Users\Events\AdminForcedPasswordReset::class => [
			Nova\Users\Listeners\NotifyUsersOfAdminForcedPasswordReset::class
		],
		Nova\Users\Events\PasswordWasGenerated::class => [
			Nova\Users\Listeners\SendPasswordToUser::class
		],
	],

	'policies' => [
		Nova\Authorize\Permission::class => Nova\Authorize\Policies\PermissionPolicy::class,
		Nova\Authorize\Role::class => Nova\Authorize\Policies\RolePolicy::class,
		Nova\Genres\Department::class => Nova\Genres\Policies\DepartmentPolicy::class,
		Nova\Users\User::class => Nova\Users\Policies\UserPolicy::class,
	],

	'restorers' => [
		Nova\Users\User::class => Nova\Users\Data\UserRestorer::class,
	],

	'updaters' => [
		Nova\Authorize\Permission::class => Nova\Authorize\Data\PermissionUpdater::class,
		Nova\Authorize\Role::class => Nova\Authorize\Data\RoleUpdater::class,
		Nova\Genres\Department::class => Nova\Genres\Data\DepartmentUpdater::class,
		Nova\Users\User::class => Nova\Users\Data\UserUpdater::class,
	],
];
