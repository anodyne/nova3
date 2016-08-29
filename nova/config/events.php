<?php

return [

	'Nova\Core\Auth\Events\LoggedIn' => [],
	'Nova\Core\Auth\Events\LoginFailed' => [],
	'Nova\Core\Auth\Events\PasswordReset' => [],
	'Nova\Core\Auth\Events\PasswordResetEmailFailed' => [],
	'Nova\Core\Auth\Events\PasswordResetEmailSent' => [],
	'Nova\Core\Auth\Events\PasswordResetFailed' => [],
	'Nova\Core\Auth\Events\PasswordResetRequired' => [],

	'Nova\Core\Pages\Events\PageCreated' => [
		CachePageRoutes::class,
	],
	'Nova\Core\Pages\Events\PageDeleted' => [
		CachePageRoutes::class,
	],
	'Nova\Core\Pages\Events\PageUpdated' => [
		CachePageRoutes::class,
	],

	'Nova\Core\Pages\Events\PageContentCreated' => [],
	'Nova\Core\Pages\Events\PageContentDeleted' => [],
	'Nova\Core\Pages\Events\PageContentUpdated' => [],

	'Nova\Core\Menus\Events\MenuItemCreated' => [],
	'Nova\Core\Menus\Events\MenuItemDeleted' => [],
	'Nova\Core\Menus\Events\MenuItemUpdated' => [],
	
	'Nova\Core\Menus\Events\MenuCreated' => [],
	'Nova\Core\Menus\Events\MenuDeleted' => [],
	'Nova\Core\Menus\Events\MenuUpdated' => [],

	'Nova\Core\Access\Events\PermissionCreated' => [],
	'Nova\Core\Access\Events\PermissionDeleted' => [],
	'Nova\Core\Access\Events\PermissionUpdated' => [],

	'Nova\Core\Access\Events\RoleCreated' => [],
	'Nova\Core\Access\Events\RoleDeleted' => [],
	'Nova\Core\Access\Events\RoleDuplicated' => [],
	'Nova\Core\Access\Events\RoleUpdated' => [],

	'Nova\Core\Forms\Events\FormCreated' => [],
	'Nova\Core\Forms\Events\FormDeleted' => [],
	'Nova\Core\Forms\Events\FormUpdated' => [],

	'Nova\Core\Forms\Events\FormTabCreated' => [],
	'Nova\Core\Forms\Events\FormTabDeleted' => [],
	'Nova\Core\Forms\Events\FormTabOrderUpdated' => [],
	'Nova\Core\Forms\Events\FormTabUpdated' => [],

	'Nova\Core\Forms\Events\FormSectionCreated' => [],
	'Nova\Core\Forms\Events\FormSectionDeleted' => [],
	'Nova\Core\Forms\Events\FormSectionOrderUpdated' => [],
	'Nova\Core\Forms\Events\FormSectionUpdated' => [],

	'Nova\Core\Forms\Events\FormFieldCreated' => [],
	'Nova\Core\Forms\Events\FormFieldDeleted' => [],
	'Nova\Core\Forms\Events\FormFieldOrderUpdated' => [],
	'Nova\Core\Forms\Events\FormFieldUpdated' => [],

	'Nova\Core\Forms\Events\FormCenterFormCreated' => [
		EmailFormCenterRecipients::class,
	],
	'Nova\Core\Forms\Events\FormCenterFormUpdated' => [
		EmailFormCenterRecipients::class,
	],
	'Nova\Core\Forms\Events\FormCenterFormDeleted' => [],

	'Nova\Core\Users\Events\UserCreated' => [
		BuildUserPreferences::class,
	],
	'Nova\Core\Users\Events\UserDeleted' => [],
	'Nova\Core\Users\Events\UserUpdated' => [],
	'Nova\Core\Users\Events\UserCreatedByAdmin' => [
		EmailNewUserPassword::class,
	],

];
