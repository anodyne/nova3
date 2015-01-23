<?php

return [

	'default' => 'mysql',

	'connections' => [
		'mysql' => [
			'host' => env('DB_HOST', '#DB_HOST#'),
			'database' => env('DB_NAME', '#DB_DATABASE#'),
			'username' => env('DB_USERNAME', '#DB_USERNAME#'),
			'password' => env('DB_PASSWORD', '#DB_PASSWORD#'),
			'prefix' => env('DB_PREFIX', '#DB_PREFIX#'),
		],
	],

];