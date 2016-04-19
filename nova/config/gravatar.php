<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Gravatar Size
	|--------------------------------------------------------------------------
	|
	| You may request a specific image size (1 - 2048px), which will be
	| dynamically delivered by Gravatar. If no size parameter is
	| supplied, images are presented at 80px by default.
	|
	*/

	'size' => null,

	/*
	|--------------------------------------------------------------------------
	| Default Image
	|--------------------------------------------------------------------------
	|
	| If there is no image associated with the requested email, Gravatar will
	| automatically serve up that image. Gravatar has a number of built
	| in options which you can use, or you can supply a image url.
	|
	| Options: '404', 'mm', 'identicon', 'monsterid',
	|          'wavatar', 'retro', 'blank'
	|
	*/

	'default-image' => null,

	/*
	|--------------------------------------------------------------------------
	| Force Default Image
	|--------------------------------------------------------------------------
	|
	| If enabled, the default image forced to always load. That means
	| Gravatar returns the default image, even if the requested
	| email already have an associated image to display.
	|
	*/

	'force-default' => false,

	/*
	|--------------------------------------------------------------------------
	| Rating Level
	|--------------------------------------------------------------------------
	|
	| If the requested email doesn't have an image meeting the requested
	| rating level, then the default image is returned. By default,
	| Gravatar displays suitable images for all websites.
	|
	|
	| Options: 'pg', 'r', 'x'
	|
	*/

	'rating' => null,

	/*
	|--------------------------------------------------------------------------
	| Secure Requests
	|--------------------------------------------------------------------------
	|
	| When your application is being served over SSL, then you'll want to
	| serve your Gravatars via SSL as well. If disabled, you'll get
	| annoying security warnings in most browsers.
	|
	*/

	'secure' => true,

];
