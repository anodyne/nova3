<?php

return [

	'Nova\Core\Pages\Events\PageWasCreated' => [
		CachePageRoutes::class,
	],
	'Nova\Core\Pages\Events\PageWasDeleted' => [
		CachePageRoutes::class,
	],
	'Nova\Core\Pages\Events\PageWasUpdated' => [
		CachePageRoutes::class,
	],

	'Nova\Core\Pages\Events\PageContentWasCreated' => [],
	'Nova\Core\Pages\Events\PageContentWasDeleted' => [],
	'Nova\Core\Pages\Events\PageContentWasUpdated' => [],

	'Nova\Core\Menus\Events\MenuItemWasCreated' => [],
	'Nova\Core\Menus\Events\MenuItemWasDeleted' => [],
	'Nova\Core\Menus\Events\MenuItemWasUpdated' => [],
	
	'Nova\Core\Menus\Events\MenuWasCreated' => [],
	'Nova\Core\Menus\Events\MenuWasDeleted' => [],
	'Nova\Core\Menus\Events\MenuWasUpdated' => [],

	'Nova\Core\Access\Events\PermissionWasCreated' => [],
	'Nova\Core\Access\Events\PermissionWasDeleted' => [],
	'Nova\Core\Access\Events\PermissionWasUpdated' => [],

	'Nova\Core\Access\Events\RoleWasCreated' => [],
	'Nova\Core\Access\Events\RoleWasDeleted' => [],
	'Nova\Core\Access\Events\RoleWasDuplicated' => [],
	'Nova\Core\Access\Events\RoleWasUpdated' => [],

	'Nova\Core\Forms\Events\FormWasCreated' => [],
	'Nova\Core\Forms\Events\FormWasDeleted' => [],
	'Nova\Core\Forms\Events\FormWasUpdated' => [],

	'Nova\Core\Forms\Events\FormTabWasCreated' => [],
	'Nova\Core\Forms\Events\FormTabWasDeleted' => [],
	'Nova\Core\Forms\Events\FormTabOrderWasUpdated' => [],
	'Nova\Core\Forms\Events\FormTabWasUpdated' => [
		CleanupFormFields::class,
		CleanupFormSections::class,
		CleanupFormTabs::class,
	],

];
