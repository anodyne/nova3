<?php

return [
	[
		'page_id' => 1,
		'type' => 'header',
		'key' => 'home.header',
		'value' => "Welcome to the {% setting:sim_name %}!"
	],
	[
		'page_id' => 1,
		'type' => 'title',
		'key' => 'home.title',
		'value' => "Home"
	],
	[
		'page_id' => 1,
		'type' => 'message',
		'key' => 'home.message',
		'value' => "This is my first message. And here is a {% page:home:link %} to the homepage using the new page compiler engine!"
	],

	[
		'page_id' => 9,
		'type' => 'header',
		'key' => 'admin.pages.header',
		'value' => "Page Manager"
	],
	[
		'page_id' => 9,
		'type' => 'title',
		'key' => 'admin.pages.title',
		'value' => "Page Manager"
	],

	[
		'page_id' => 10,
		'type' => 'title',
		'key' => 'admin.pages.edit.title',
		'value' => "Edit Page"
	],
];
