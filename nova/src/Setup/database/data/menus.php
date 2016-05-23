<?php

return [

	'menus' => [
		['name' => "Public", 'key' => "public"],
		['name' => "Admin", 'key' => "admin"],
	],

	'menuItems' => [
		['menu_id' => 1, 'order' => 0, 'type' => "route", 'link' => "setup.home", 'title' => "Setup Center"],
		['menu_id' => 1, 'order' => 1, 'type' => "internal", 'link' => "#", 'title' => "Admin"],
		['menu_id' => 1, 'parent_id' => 2, 'order' => 0, 'type' => "page", 'page_id' => 9, 'title' => "Pages", 'access_type' => 'permissions-loose', 'access' => '[{"type":"permission","name":"Create Pages","key":"page.create"},{"type":"permission","name":"Edit Pages","key":"page.edit"},{"type":"permission","name":"Remove Pages","key":"page.remove"}]'],
		['menu_id' => 1, 'parent_id' => 2, 'order' => 1, 'type' => "page", 'page_id' => 26, 'title' => "Menus", 'access_type' => 'permissions-loose', 'access' => '[{"type":"permission","name":"Create Menus","key":"menu.create"},{"type":"permission","name":"Edit Menus","key":"menu.edit"},{"type":"permission","name":"Remove Menus","key":"menu.remove"}]'],
		['menu_id' => 1, 'parent_id' => 2, 'order' => 2, 'type' => "page", 'page_id' => 46, 'title' => "Roles", 'access_type' => 'permissions-loose', 'access' => '[{"type":"permission","name":"Create Roles","key":"access.create"},{"type":"permission","name":"Edit Roles","key":"access.edit"},{"type":"permission","name":"Remove Roles","key":"access.remove"}]'],
		['menu_id' => 1, 'parent_id' => 2, 'order' => 3, 'type' => "page", 'page_id' => 65, 'title' => "Forms", 'access_type' => 'permissions-loose', 'access' => '[{"type":"permission","name":"Create Forms","key":"form.create"},{"type":"permission","name":"Edit Forms","key":"form.edit"},{"type":"permission","name":"Remove Forms","key":"form.remove"}]'],
		['menu_id' => 1, 'parent_id' => 2, 'order' => 4, 'type' => "page", 'page_id' => 111, 'title' => "Users", 'access_type' => 'permissions-loose', 'access' => '[{"type":"permission","name":"Create Users","key":"user.create"},{"type":"permission","name":"Edit Users","key":"user.edit"},{"type":"permission","name":"Remove Users","key":"user.remove"}]'],

		['menu_id' => 2, 'order' => 0, 'type' => "page", 'page_id' => 99],

		['menu_id' => 2, 'order' => 1, 'type' => "internal", 'link' => "#", 'title' => "Manage"],
		['menu_id' => 2, 'parent_id' => 9, 'order' => 0, 'type' => "page", 'page_id' => 9, 'title' => "Pages", 'access_type' => 'permissions-loose', 'access' => '[{"type":"permission","name":"Create Pages","key":"page.create"},{"type":"permission","name":"Edit Pages","key":"page.edit"},{"type":"permission","name":"Remove Pages","key":"page.remove"}]'],
		['menu_id' => 2, 'parent_id' => 9, 'order' => 1, 'type' => "page", 'page_id' => 18, 'title' => "Additional Content", 'access_type' => 'permissions-loose', 'access' => '[{"type":"permission","name":"Create Pages","key":"page.create"},{"type":"permission","name":"Edit Pages","key":"page.edit"},{"type":"permission","name":"Remove Pages","key":"page.remove"}]'],
		['menu_id' => 2, 'parent_id' => 9, 'order' => 2, 'type' => "divider"],
		['menu_id' => 2, 'parent_id' => 9, 'order' => 3, 'type' => "page", 'page_id' => 26, 'title' => "Menus", 'access_type' => 'permissions-loose', 'access' => '[{"type":"permission","name":"Create Menus","key":"menu.create"},{"type":"permission","name":"Edit Menus","key":"menu.edit"},{"type":"permission","name":"Remove Menus","key":"menu.remove"}]'],
		['menu_id' => 2, 'parent_id' => 9, 'order' => 4, 'type' => "divider"],
		['menu_id' => 2, 'parent_id' => 9, 'order' => 5, 'type' => "page", 'page_id' => 46, 'title' => "Roles", 'access_type' => 'permissions-loose', 'access' => '[{"type":"permission","name":"Create Roles","key":"access.create"},{"type":"permission","name":"Edit Roles","key":"access.edit"},{"type":"permission","name":"Remove Roles","key":"access.remove"}]'],
		['menu_id' => 2, 'parent_id' => 9, 'order' => 6, 'type' => "divider"],
		['menu_id' => 2, 'parent_id' => 9, 'order' => 7, 'type' => "page", 'page_id' => 65, 'title' => "Forms", 'access_type' => 'permissions-loose', 'access' => '[{"type":"permission","name":"Create Forms","key":"form.create"},{"type":"permission","name":"Edit Forms","key":"form.edit"},{"type":"permission","name":"Remove Forms","key":"form.remove"}]'],
		['menu_id' => 2, 'parent_id' => 9, 'order' => 8, 'type' => "divider"],
		['menu_id' => 2, 'parent_id' => 9, 'order' => 9, 'type' => "page", 'page_id' => 111, 'title' => "Users", 'access_type' => 'permissions-loose', 'access' => '[{"type":"permission","name":"Create Users","key":"user.create"},{"type":"permission","name":"Edit Users","key":"user.edit"},{"type":"permission","name":"Remove Users","key":"user.remove"}]'],
	],

];
