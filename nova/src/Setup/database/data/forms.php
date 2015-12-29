<?php

return [

	'forms' => [

		['key' => 'application', 'name' => 'Additional Application Information', 'protected' => (int) true],
		['key' => 'character', 'name' => 'Character Information', 'protected' => (int) true],
		['key' => 'user', 'name' => 'User Information', 'protected' => (int) true],

	],

	'application' => [],

	'character' => [

		'tabs' => [
			['form_id' => 2, 'name' => 'Basic Info', 'link_id' => 'basic-info', 'order' => 0, 'status' => Status::ACTIVE],
			['form_id' => 2, 'name' => 'Personality', 'link_id' => 'personality', 'order' => 1, 'status' => Status::ACTIVE],
			['form_id' => 2, 'name' => 'Personal History', 'link_id' => 'personal-history', 'order' => 2, 'status' => Status::ACTIVE],
		],

		'sections' => [
			['form_id' => 2, 'tab_id' => 1, 'name' => 'Character Information', 'order' => 0, 'status' => Status::ACTIVE],
			['form_id' => 2, 'tab_id' => 1, 'name' => 'Physical Appearance', 'order' => 1, 'status' => Status::ACTIVE],
			['form_id' => 2, 'tab_id' => 1, 'name' => 'Family', 'order' => 2, 'status' => Status::ACTIVE],
			['form_id' => 2, 'tab_id' => 2, 'name' => 'Personality &amp; Traits', 'order' => 0, 'status' => Status::ACTIVE],
		],

	],

	'user' => [],

];
