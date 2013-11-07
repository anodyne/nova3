<?php

return [
	/**
	 * Main Navigation
	 */
	[
		'name' => 'Main',
		'group' => 0,
		'order' => 0,
		'url' => '/',
		'type' => 'main',
		'category' => 'main'
	],
	/*[
		'name' => 'Personnel',
		'group' => 0,
		'order' => 1,
		'url' => 'personnel/index',
		'sim_type' => 1,
		'category' => 'main'
	],
	[
		'name' => 'Sim',
		'group' => 0,
		'order' => 2,
		'url' => 'sim/index',
		'sim_type' => 1,
		'category' => 'main'
	],
	[
		'name' => 'Wiki',
		'group' => 0,
		'order' => 3,
		'url' => 'wiki/index',
		'sim_type' => 1,
		'category' => 'main',
		'status' => (int) true
	],
	[
		'name' => 'Forums',
		'group' => 0,
		'order' => 3,
		'url' => 'forums/index',
		'sim_type' => 1,
		'category' => 'main',
		'status' => (int) true
	],
	[
		'name' => 'Search',
		'group' => 0,
		'order' => 4,
		'url' => 'search/index',
		'sim_type' => 1,
		'category' => 'main'
	],
	*/
	
	/**
	 * Sub Navigation
	 */	
	[
		'name' => 'Main',
		'group' => 0,
		'order' => 0,
		'url' => '/',
		'type' => 'sub',
		'category' => 'main'
	],
	/*[
		'name' => 'Announcements',
		'group' => 0,
		'order' => 1,
		'url' => 'announcements',
		'type' => 'sub',
		'category' => 'main'
	],
	[
		'name' => 'Contact',
		'group' => 0,
		'order' => 2,
		'url' => 'contact',
		'type' => 'sub',
		'category' => 'main'
	],*/
	[
		'name' => 'Credits',
		'group' => 0,
		'order' => 3,
		'url' => 'credits',
		'type' => 'sub',
		'category' => 'main'
	],
	/*[
		'name' => 'Join',
		'group' => 1,
		'order' => 0,
		'url' => 'join',
		'type' => 'sub',
		'category' => 'main'
	],
	/*[
		'name' => 'Search',
		'group' => 2,
		'order' => 0,
		'url' => 'search',
		'type' => 'sub',
		'category' => 'main'
	],
	[
		'name' => 'Manifest',
		'group' => 0,
		'order' => 0,
		'url' => 'personnel/index',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'personnel'
	],
	[
		'name' => 'Awards',
		'group' => 0,
		'order' => 2,
		'url' => 'sim/awards',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'personnel'
	],
	[
		'name' => 'The Sim',
		'group' => 0,
		'order' => 0,
		'url' => 'sim/index',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'sim'
	],
	[
		'name' => 'Missions',
		'group' => 0,
		'order' => 1,
		'url' => 'sim/missions',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'sim'
	],
	[
		'name' => 'Mission Groups',
		'group' => 0,
		'order' => 2,
		'url' => 'sim/missions/group',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'sim'
	],
	[
		'name' => 'Personal Logs',
		'group' => 0,
		'order' => 3,
		'url' => 'sim/listlogs',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'sim'
	],
	[
		'name' => 'Stats',
		'group' => 0,
		'order' => 4,
		'url' => 'sim/stats',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'sim'
	],
	[
		'name' => 'Awards',
		'group' => 0,
		'order' => 5,
		'url' => 'sim/awards',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'sim'
	],
	[
		'name' => 'Departments',
		'group' => 1,
		'order' => 3,
		'url' => 'sim/departments',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'sim'
	],
		
	[
		'name' => 'Main Page',
		'group' => 0,
		'order' => 0,
		'url' => 'wiki/index',
		'sim_type' => 1,
		'status' => 1,
		'type' => 'sub',
		'category' => 'wiki'
	],
	[
		'name' => 'Recent Changes',
		'group' => 0,
		'order' => 1,
		'url' => 'wiki/recent',
		'sim_type' => 1,
		'status' => 1,
		'type' => 'sub',
		'category' => 'wiki'
	],
	[
		'name' => 'Categories',
		'group' => 0,
		'order' => 2,
		'url' => 'wiki/categories',
		'sim_type' => 1,
		'status' => 1,
		'type' => 'sub',
		'category' => 'wiki'
	],
	[
		'name' => 'Manage Pages',
		'group' => 1,
		'order' => 0,
		'url' => 'wiki/managepages',
		'sim_type' => 1,
		'status' => 1,
		'type' => 'sub',
		'use_access' => 1,
		'access' => 'wiki/page',
		'needs_login' => 'y',
		'category' => 'wiki'
	],
	[
		'name' => 'Manage Categories',
		'group' => 1,
		'order' => 1,
		'url' => 'wiki/managecategories',
		'sim_type' => 1,
		'status' => 1,
		'type' => 'sub',
		'use_access' => 1,
		'access' => 'wiki/categories',
		'needs_login' => 'y',
		'category' => 'wiki'
	],
	[
		'name' => 'Create New Page',
		'group' => 2,
		'order' => 0,
		'url' => 'wiki/page',
		'sim_type' => 1,
		'status' => 1,
		'type' => 'sub',
		'use_access' => 1,
		'access' => 'wiki/page',
		'needs_login' => 'y',
		'category' => 'wiki'
	],
	*/
	
	/**
	 * Admin Main Navigation
	 */
	/*[
		'name' => 'Control Panel',
		'group' => 0,
		'order' => 0,
		'url' => 'admin',
		'type' => 'admin',
		'category' => 'admin'
	],
	/*[
		'name' => 'Messages',
		'group' => 0,
		'order' => 1,
		'type' => 'admin',
		'category' => 'messages',
		'access' => 'messages.read.0'
	],
	[
		'name' => 'Writing',
		'group' => 0,
		'order' => 2,
		'type' => 'admin',
		'category' => 'write'
	],*/
	[
		'name' => 'Manage',
		'group' => 0,
		'order' => 3,
		'type' => 'admin',
		'category' => 'manage'
	],
	[
		'name' => 'Characters &amp; Users',
		'group' => 0,
		'order' => 4,
		'type' => 'admin',
		'category' => 'users'
	],
	/*[
		'name' => 'Report Center',
		'group' => 0,
		'order' => 5,
		'url' => 'admin/report/index',
		'type' => 'admin',
		'category' => 'report',
		'access' => 'report.read.1'
	],*/

	/**
	 * Admin Sub Navigation
	 */
	/*[
		'name' => 'Writing Control Panel',
		'group' => 0,
		'order' => 0,
		'url' => 'admin/write/index',
		'type' => 'adminsub',
		'category' => 'write'
	],
	[
		'name' => 'Mission Post',
		'group' => 1,
		'order' => 0,
		'url' => 'admin/write/post',
		'type' => 'adminsub',
		'category' => 'write',
		'access' => 'post.create.0'
	],
	[
		'name' => 'Personal Log',
		'group' => 1,
		'order' => 1,
		'url' => 'admin/write/log',
		'type' => 'adminsub',
		'category' => 'write',
		'access' => 'log.create.0'
	],
	[
		'name' => 'Announcement',
		'group' => 1,
		'order' => 2,
		'url' => 'admin/write/announcement',
		'type' => 'adminsub',
		'category' => 'write',
		'access' => 'announcement.create.0'
	],
	[
		'name' => 'Write New Message',
		'group' => 0,
		'order' => 0,
		'url' => 'admin/messages/write',
		'type' => 'adminsub',
		'category' => 'messages',
		'access' => 'messages.create.0'
	],
	[
		'name' => 'Inbox',
		'group' => 1,
		'order' => 0,
		'url' => 'admin/messages/index',
		'type' => 'adminsub',
		'category' => 'messages',
		'access' => 'messages.read.0'
	],
	[
		'name' => 'Sent Messages',
		'group' => 1,
		'order' => 1,
		'url' => 'admin/messages/sent',
		'type' => 'adminsub',
		'category' => 'messages',
		'access' => 'messages.read.0'
	],*/
	[
		'name' => 'Routes',
		'group' => 0,
		'order' => 0,
		'url' => 'admin/routes',
		'type' => 'adminsub',
		'category' => 'manage',
		'access' => 'routes.create|routes.update|routes.delete'
	],
	/*[
		'name' => 'Settings',
		'group' => 0,
		'order' => 1,
		'url' => 'admin/settings',
		'type' => 'adminsub',
		'category' => 'manage',
		'access' => 'settings.create|settings.update|settings.delete'
	],*/
	[
		'name' => 'Site Content',
		'group' => 0,
		'order' => 2,
		'url' => 'admin/sitecontent',
		'type' => 'adminsub',
		'category' => 'manage',
		'access' => 'content.create|content.update|content.delete'
	],
	[
		'name' => 'Site Navigation',
		'group' => 0,
		'order' => 3,
		'url' => 'admin/navigation',
		'type' => 'adminsub',
		'category' => 'manage',
		'access' => 'nav.create|nav.update|nav.delete'
	],
	[
		'name' => 'Access Roles',
		'group' => 1,
		'order' => 0,
		'url' => 'admin/role',
		'type' => 'adminsub',
		'category' => 'manage',
		'access' => 'role.create|role.update|role.delete'
	],
	[
		'name' => 'Forms',
		'group' => 1,
		'order' => 1,
		'url' => 'admin/form',
		'type' => 'adminsub',
		'category' => 'manage',
		'access' => 'form.read|form.create|form.update|form.delete'
	],
	[
		'name' => 'Resource Catalogs',
		'group' => 1,
		'order' => 2,
		'url' => 'admin/catalog',
		'type' => 'adminsub',
		'category' => 'manage',
		'access' => 'catalog.create|catalog.update|catalog.delete'
	],
	/*[
		'name' => 'Ranks',
		'group' => 2,
		'order' => 0,
		'url' => 'admin/rank/index',
		'type' => 'adminsub',
		'category' => 'manage',
		'access' => 'rank.create|rank.update|rank.delete'
	],*/

	[
		'name' => 'All Users',
		'group' => 0,
		'order' => 0,
		'url' => 'admin/user',
		'type' => 'adminsub',
		'category' => 'users',
		'access' => 'user.create|user.delete'
	],
	/*[
		'name' => 'All Characters',
		'group' => 1,
		'order' => 0,
		'url' => 'admin/character/index',
		'type' => 'adminsub',
		'category' => 'users',
		'access' => 'character.create|character.delete'
	],*/
	/*[
		'name' => 'Application Review',
		'group' => 2,
		'order' => 0,
		'url' => 'admin/application/index',
		'type' => 'adminsub',
		'category' => 'users',
		'access' => ''
	],*/
	/*
	[
		'name' => 'Awards',
		'group' => 0,
		'order' => 0,
		'url' => 'manage/awards',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/awards'
	],
	[
		'name' => 'Departments',
		'group' => 0,
		'order' => 1,
		'url' => 'manage/depts',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/depts'
	],
	[
		'name' => 'Positions',
		'group' => 0,
		'order' => 2,
		'url' => 'manage/positions',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/positions'
	],
	[
		'name' => 'Missions',
		'group' => 1,
		'order' => 0,
		'url' => 'manage/missions',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/missions'
	],
	[
		'name' => 'Mission Groups',
		'group' => 1,
		'order' => 1,
		'url' => 'manage/missiongroups',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/missions'
	],
	[
		'name' => 'Mission Posts',
		'group' => 1,
		'order' => 2,
		'url' => 'manage/posts',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/posts'
	],
	[
		'name' => 'Personal Logs',
		'group' => 1,
		'order' => 3,
		'url' => 'manage/logs',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/logs'
	],
	[
		'name' => 'News Items',
		'group' => 1,
		'order' => 4,
		'url' => 'manage/news',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/news'
	],
	[
		'name' => 'News Categories',
		'group' => 1,
		'order' => 5,
		'url' => 'manage/newscats',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/newscats'
	],
	[
		'name' => 'Comments',
		'group' => 1,
		'order' => 6,
		'url' => 'manage/comments',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/comments'
	],
	[
		'name' => 'Upload Images',
		'group' => 3,
		'order' => 0,
		'url' => 'upload/index',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 0
	],
	[
		'name' => 'Manage Uploads',
		'group' => 3,
		'order' => 1,
		'url' => 'upload/manage',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'upload/manage'
	],
	[
		'name' => 'All Characters',
		'group' => 0,
		'order' => 0,
		'url' => 'characters/index',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'characters',
		'use_access' => 1,
		'access' => 'characters/index'
	],
	[
		'name' => 'All NPCs',
		'group' => 0,
		'order' => 1,
		'url' => 'characters/npcs',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'characters',
		'use_access' => 1,
		'access' => 'characters/npcs'
	],
	[
		'name' => 'Create Character',
		'group' => 0,
		'order' => 2,
		'url' => 'characters/create',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'characters',
		'use_access' => 1,
		'access' => 'characters/create'
	],
	[
		'name' => 'Give/Remove Awards',
		'group' => 1,
		'order' => 1,
		'url' => 'characters/awards',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'characters',
		'use_access' => 1,
		'access' => 'characters/awards'
	],
	[
		'name' => 'My Account',
		'group' => 0,
		'order' => 0,
		'url' => 'admin/users/account',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'user',
		'access' => 'user.update.1'
	],
	[
		'name' => 'My Bio',
		'group' => 0,
		'order' => 1,
		'url' => 'characters/bio',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'user',
		'use_access' => 1,
		'access' => 'characters/bio'
	],
	[
		'name' => 'Site Options',
		'group' => 1,
		'order' => 0,
		'url' => 'user/options',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'user',
		'use_access' => 1,
		'access' => 'user/account'
	],
	[
		'name' => 'Request LOA',
		'group' => 0,
		'order' => 1,
		'url' => 'admin/users/status',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'user',
		'access' => 'user.update.1'
	],
	[
		'name' => 'Award Nominations',
		'group' => 0,
		'order' => 2,
		'url' => 'admin/users/nominate',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'user',
		'access' => 'user.update.1'
	],
	[
		'name' => 'All Users',
		'group' => 1,
		'order' => 0,
		'url' => 'admin/users/index',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'user',
		'access' => 'user.read.0'
	],
	[
		'name' => 'Link Characters',
		'group' => 1,
		'order' => 1,
		'url' => 'admin/users/link',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'user',
		'access' => 'user.update.2'
	],
	*/
];