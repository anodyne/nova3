<?php

return [
	'creators' => [
		Nova\Authorize\Permission::class => Nova\Authorize\Data\PermissionCreator::class,
		Nova\Authorize\Role::class => Nova\Authorize\Data\RoleCreator::class,
		Nova\Genres\Department::class => Nova\Genres\Data\DepartmentCreator::class,
		Nova\Genres\Position::class => Nova\Genres\Data\PositionCreator::class,
		Nova\Genres\RankGroup::class => Nova\Genres\Data\RankGroupCreator::class,
		Nova\Users\User::class => Nova\Users\Data\UserCreator::class,
	],

	'deletors' => [
		Nova\Authorize\Permission::class => Nova\Authorize\Data\PermissionDeletor::class,
		Nova\Authorize\Role::class => Nova\Authorize\Data\RoleDeletor::class,
		Nova\Genres\Department::class => Nova\Genres\Data\DepartmentDeletor::class,
		Nova\Genres\Position::class => Nova\Genres\Data\PositionDeletor::class,
		Nova\Genres\RankGroup::class => Nova\Genres\Data\RankGroupDeletor::class,
		Nova\Users\User::class => Nova\Users\Data\UserDeletor::class,
	],

	'duplicators' => [
		Nova\Genres\RankGroup::class => Nova\Genres\Data\RankGroupDuplicator::class,
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
		Nova\Genres\Position::class => Nova\Genres\Policies\PositionPolicy::class,
		Nova\Genres\RankGroup::class => Nova\Genres\Policies\RankPolicy::class,
		Nova\Users\User::class => Nova\Users\Policies\UserPolicy::class,
	],

	'restorers' => [
		Nova\Users\User::class => Nova\Users\Data\UserRestorer::class,
	],

	'updaters' => [
		Nova\Authorize\Permission::class => Nova\Authorize\Data\PermissionUpdater::class,
		Nova\Authorize\Role::class => Nova\Authorize\Data\RoleUpdater::class,
		Nova\Genres\Department::class => Nova\Genres\Data\DepartmentUpdater::class,
		Nova\Genres\Position::class => Nova\Genres\Data\PositionUpdater::class,
		Nova\Genres\RankGroup::class => Nova\Genres\Data\RankGroupUpdater::class,
		Nova\Users\User::class => Nova\Users\Data\UserUpdater::class,
	],
];
