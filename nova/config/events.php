<?php

return [

	'Nova\Core\Pages\Events\PageWasCreated' => [
		'Nova\Core\Pages\Handlers\Events\CachePageRoutes',
	],

	'Nova\Core\Pages\Events\PageWasDeleted' => [
		'Nova\Core\Pages\Handlers\Events\CachePageRoutes',
	],

	'Nova\Core\Pages\Events\PageWasUpdated' => [
		'Nova\Core\Pages\Handlers\Events\CachePageRoutes',
	],

];
