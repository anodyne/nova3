<?php

return [

	'app' => [
		'name'	=> "Nova NextGen",

		'version' => [
			'full'	=> '0.4.0',
			'major'	=> 0,
			'minor'	=> 4,
			'patch'	=> 0,
		],
	],

	'api' => [
		'prefix' => 'api',
		'version' => 'v1',

		'acceptHeader' => 'application/x.nova3.v1+json',
	],

	'forms' => [
		'fieldNameFormat' => "field_%d",
	],

];