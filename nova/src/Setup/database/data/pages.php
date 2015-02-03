<?php

$pages = [
	[
		'verb'				=> "GET",
		'name'				=> "home",
		'uri'				=> "/",
		'default_resource'	=> "Nova\\Core\\Game\\Http\\Controllers\\HomeController@home",
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
