<?php

return [

	'default' => env('DB_DRIVER', '#DB_DRIVER#'),

	'connections' => [
		'sqlite' => [
			'prefix'   => env('DB_PREFIX', '#DB_PREFIX#'),
		],

		'mysql' => [
			'host' => env('DB_HOST', '#DB_HOST#'),
			'database' => env('DB_NAME', '#DB_DATABASE#'),
			'username' => env('DB_USERNAME', '#DB_USERNAME#'),
			'password' => env('DB_PASSWORD', '#DB_PASSWORD#'),
			'prefix' => env('DB_PREFIX', '#DB_PREFIX#'),
		],

		'pgsql' => [
			'host'     => env('DB_HOST', '#DB_HOST#'),
			'database' => env('DB_DATABASE', '#DB_DATABASE#'),
			'username' => env('DB_USERNAME', '#DB_USERNAME#'),
			'password' => env('DB_PASSWORD', '#DB_PASSWORD#'),
			'prefix'   => env('DB_PREFIX', '#DB_PREFIX#'),
		],
	],

];