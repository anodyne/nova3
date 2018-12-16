<?php

return [
	Illuminate\Auth\Events\Authenticated::class => [
		Nova\Auth\Listeners\RecordsUserLogin::class,
	],
	Illuminate\Auth\Events\Registered::class => [
		Illuminate\Auth\Listeners\SendEmailVerificationNotification::class,
	],
	Nova\Users\Events\AdminForcedPasswordReset::class => [
		Nova\Users\Listeners\NotifyUsersOfAdminForcedPasswordReset::class
	],
	Nova\Users\Events\UserWasCreatedByAdmin::class => [
		Nova\Users\Listeners\NotifyUserOfAdminAccountCreation::class
	],
	// Nova\Users\Events\PasswordWasGenerated::class => [
	// 	Nova\Users\Listeners\SendPasswordToUser::class
	// ],
];