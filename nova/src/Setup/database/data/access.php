<?php

return [

	'roles' => [
		['name' => "Game Master", 'key' => "game-master"],
		['name' => "Power User", 'key' => "power-user"],
		['name' => "Active User", 'key' => "active-user"],
		['name' => "Inactive User", 'key' => "inactive-user"],
	],

	'permissions' => [
		['name' => "Create Pages", 'key' => "page.create", 'description' => "Create new pages or additional page content.", 'protected' => (int) true],
		['name' => "Edit Pages", 'key' => "page.edit", 'description' => "Edit existing pages or additional page content.", 'protected' => (int) true],
		['name' => "Remove Pages", 'key' => "page.remove", 'description' => "Remove existing pages or additional page content.", 'protected' => (int) true],

		['name' => "Create Menus", 'key' => "menu.create", 'description' => "Create new menus and menu items.", 'protected' => (int) true],
		['name' => "Edit Menus", 'key' => "menu.edit", 'description' => "Edit existing menus or menu items.", 'protected' => (int) true],
		['name' => "Remove Menus", 'key' => "menu.remove", 'description' => "Remove existing menus or menu items.", 'protected' => (int) true],

		['name' => "Create Roles", 'key' => "access.create", 'description' => "Create new roles and role permissions.", 'protected' => (int) true],
		['name' => "Edit Roles", 'key' => "access.edit", 'description' => "Edit existing roles and role permissions.", 'protected' => (int) true],
		['name' => "Remove Roles", 'key' => "access.remove", 'description' => "Remove existing roles and role permissions.", 'protected' => (int) true],

		['name' => "Create Forms", 'key' => "form.create", 'description' => "Create new forms.", 'protected' => (int) true],
		['name' => "Edit Forms", 'key' => "form.edit", 'description' => "Edit existing forms.", 'protected' => (int) true],
		['name' => "Remove Forms", 'key' => "form.remove", 'description' => "Remove existing forms.", 'protected' => (int) true],

		['name' => "View Form Entries", 'key' => "form-center.view", 'description' => "View form entries created from Form Center.", 'protected' => (int) true],
		['name' => "Edit Form Entries", 'key' => "form-center.edit", 'description' => "Edit any form entries created from Form Center.", 'protected' => (int) true],
		['name' => "Remove Form Entries", 'key' => "form-center.remove", 'description' => "Remove any form entries created from Form Center.", 'protected' => (int) true],

		['name' => "Create Users", 'key' => "user.create", 'description' => "Create new users.", 'protected' => (int) true],
		['name' => "Edit Users", 'key' => "user.edit", 'description' => "Edit existing users.", 'protected' => (int) true],
		['name' => "Remove Users", 'key' => "user.remove", 'description' => "Remove existing users.", 'protected' => (int) true],
	],

	'roleAssociations' => [
		'Game Master' => [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18],
		'Power User' => [],
		'Active User' => [],
		'Inactive User' => [],
	],

];
