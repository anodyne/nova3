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

];
