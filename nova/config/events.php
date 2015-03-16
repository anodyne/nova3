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

];
