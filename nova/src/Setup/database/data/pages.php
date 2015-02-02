<?php

$pages = [
	[
		'type'				=> "GET",
		'name'				=> "home",
		'uri'				=> "/",
		'default_resource'	=> "Nova\\Core\\Game\\Controllers\\GameController@home",
		'protected'			=> (int) true,
	],
];

$collections = [];

$content = [];

$navigation = [];

$data = [
	'pages'			=> $pages,
	'collections'	=> $collections,
	'content'		=> $content,
	'navigation'	=> $navigation,
];

return $data;
