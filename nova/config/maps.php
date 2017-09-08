<?php

return [
	'creators' => [
		Nova\Authorize\Permission::class => Nova\Authorize\Data\PermissionCreator::class,
		Nova\Authorize\Role::class => Nova\Authorize\Data\RoleCreator::class,
		Nova\Characters\Character::class => Nova\Characters\Data\CharacterCreator::class,
		Nova\Media\Media::class => Nova\Foundation\Data\MediaCreator::class,
		Nova\Genres\Department::class => Nova\Genres\Data\DepartmentCreator::class,
		Nova\Genres\Position::class => Nova\Genres\Data\PositionCreator::class,
		Nova\Genres\RankGroup::class => Nova\Genres\Data\RankGroupCreator::class,
		Nova\Genres\RankInfo::class => Nova\Genres\Data\RankInfoCreator::class,
		Nova\Genres\Rank::class => Nova\Genres\Data\RankCreator::class,
		Nova\Users\User::class => Nova\Users\Data\UserCreator::class,
	],

	'deletors' => [
		Nova\Authorize\Permission::class => Nova\Authorize\Data\PermissionDeletor::class,
		Nova\Authorize\Role::class => Nova\Authorize\Data\RoleDeletor::class,
		Nova\Characters\Character::class => Nova\Characters\Data\CharacterDeletor::class,
		Nova\Media\Media::class => Nova\Foundation\Data\MediaDeletor::class,
		Nova\Genres\Department::class => Nova\Genres\Data\DepartmentDeletor::class,
		Nova\Genres\Position::class => Nova\Genres\Data\PositionDeletor::class,
		Nova\Genres\RankGroup::class => Nova\Genres\Data\RankGroupDeletor::class,
		Nova\Genres\RankInfo::class => Nova\Genres\Data\RankInfoDeletor::class,
		Nova\Genres\Rank::class => Nova\Genres\Data\RankDeletor::class,
		Nova\Users\User::class => Nova\Users\Data\UserDeletor::class,
	],

	'duplicators' => [
		Nova\Genres\RankGroup::class => Nova\Genres\Data\RankGroupDuplicator::class,
		Nova\Genres\Rank::class => Nova\Genres\Data\RankDuplicator::class,
	],

	'events' => [
		Nova\Users\Events\AdminForcedPasswordReset::class => [
			Nova\Users\Listeners\NotifyUsersOfAdminForcedPasswordReset::class
		],
		Nova\Users\Events\UserWasCreatedByAdmin::class => [
			Nova\Users\Listeners\NotifyUserOfAdminAccountCreation::class
		],
		// Nova\Users\Events\PasswordWasGenerated::class => [
		// 	Nova\Users\Listeners\SendPasswordToUser::class
		// ],
	],

	'morph' => [
		'character' => Nova\Characters\Character::class,
		'user' => Nova\Users\User::class,
	],

	'policies' => [
		Nova\Authorize\Permission::class => Nova\Authorize\Policies\PermissionPolicy::class,
		Nova\Authorize\Role::class => Nova\Authorize\Policies\RolePolicy::class,
		Nova\Characters\Character::class => Nova\Characters\Policies\CharacterPolicy::class,
		Nova\Genres\Department::class => Nova\Genres\Policies\DepartmentPolicy::class,
		Nova\Genres\Position::class => Nova\Genres\Policies\PositionPolicy::class,
		Nova\Genres\RankGroup::class => Nova\Genres\Policies\RankPolicy::class,
		Nova\Genres\RankInfo::class => Nova\Genres\Policies\RankPolicy::class,
		Nova\Genres\Rank::class => Nova\Genres\Policies\RankPolicy::class,
		Nova\Users\User::class => Nova\Users\Policies\UserPolicy::class,
	],

	'restorers' => [
		Nova\Characters\Character::class => Nova\Characters\Data\CharacterRestorer::class,
		Nova\Users\User::class => Nova\Users\Data\UserRestorer::class,
	],

	'updaters' => [
		Nova\Authorize\Permission::class => Nova\Authorize\Data\PermissionUpdater::class,
		Nova\Authorize\Role::class => Nova\Authorize\Data\RoleUpdater::class,
		Nova\Characters\Character::class => Nova\Characters\Data\CharacterUpdater::class,
		Nova\Media\Media::class => Nova\Foundation\Data\MediaUpdater::class,
		Nova\Genres\Department::class => Nova\Genres\Data\DepartmentUpdater::class,
		Nova\Genres\Position::class => Nova\Genres\Data\PositionUpdater::class,
		Nova\Genres\RankGroup::class => Nova\Genres\Data\RankGroupUpdater::class,
		Nova\Genres\RankInfo::class => Nova\Genres\Data\RankInfoUpdater::class,
		Nova\Genres\Rank::class => Nova\Genres\Data\RankUpdater::class,
		Nova\Users\User::class => Nova\Users\Data\UserUpdater::class,
	],
];
