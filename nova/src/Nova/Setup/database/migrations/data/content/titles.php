<?php

/**
 * Site Content - Page Titles
 */

$type = 'title';

return [

	/**
	 * Login Page Titles
	 */
	[
		'key'		=> 'title.login',
		'label'		=> 'Log In Page Title',
		'content'	=> "Log In",
		'type'		=> $type,
		'section'	=> 'login',
		'page'		=> 'index',
		'uri'		=> 'login'
	],
	[
		'key'		=> 'title.login.reset',
		'label'		=> 'Reset Password Page Title',
		'content'	=> "Reset Password",
		'type'		=> $type,
		'section'	=> 'login',
		'page'		=> 'reset',
		'uri'		=> 'login/reset'
	],
	[
		'key'		=> 'title.login.reset_confirm',
		'label'		=> 'Confirm Reset Password Page Title',
		'content'	=> "Confirm Password Reset",
		'type'		=> $type,
		'section'	=> 'login',
		'page'		=> 'reset_confirm',
		'uri'		=> 'login/reset_confirm'
	],
	[
		'key'		=> 'title.login.logout',
		'label'		=> 'Logout Page Title',
		'content'	=> "Logout",
		'type'		=> $type,
		'section'	=> 'login',
		'page'		=> 'logout',
		'uri'		=> 'logout'
	],

	/**
	 * Main Page Titles
	 */
	[
		'key'		=> 'title.main',
		'label'		=> 'Main Page Title',
		'content'	=> "Main",
		'type'		=> $type,
		'section'	=> 'main',
		'page'		=> 'index',
		'uri'		=> 'home'
	],
	[
		'key'		=> 'title.main.credits',
		'label'		=> 'Site Credits Page Title',
		'content'	=> 'Site Credits',
		'type'		=> $type,
		'section'	=> 'main',
		'page'		=> 'credits',
		'uri'		=> 'credits'
	],
	[
		'key'		=> 'title.main.join',
		'label'		=> 'Join Page Title',
		'content'	=> 'Join',
		'type'		=> $type,
		'section'	=> 'main',
		'page'		=> 'join',
		'uri'		=> 'join'
	],

	/**
	 * Sim Page Titles
	 */
	[
		'key'		=> 'title.sim',
		'label'		=> 'Sim Page Title',
		'content'	=> "The Sim",
		'type'		=> $type,
		'section'	=> 'sim',
		'page'		=> 'index',
		'uri'		=> 'sim'
	],

	/**
	 * Personnel Page Titles
	 */

	/**
	 * admin/main Page Titles
	 */
	[
		'key'		=> 'title.admin',
		'label'		=> 'ACP Page Title',
		'content'	=> "Control Panel",
		'type'		=> $type,
		'section'	=> 'admin',
		'page'		=> 'index',
		'uri'		=> 'admin'
	],

	/**
	 * admin/form Page Titles
	 */
	[
		'key'		=> 'title.admin.form',
		'label'		=> 'Form Management Page Title',
		'content'	=> "Forms",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'forms',
		'uri'		=> 'admin/form'
	],
	[
		'key'		=> 'title.admin.form.fields',
		'label'		=> 'Form Field Management Page Title',
		'content'	=> "Form Fields",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'fields',
		'uri'		=> 'admin/form/fields'
	],
	[
		'key'		=> 'title.admin.form.sections',
		'label'		=> 'Form Section Management Page Title',
		'content'	=> "Form Sections",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'sections',
		'uri'		=> 'admin/form/sections'
	],
	[
		'key'		=> 'title.admin.form.tabs',
		'label'		=> 'Form Tab Management Page Title',
		'content'	=> "Form Tabs",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'tabs',
		'uri'		=> 'admin/form/tabs'
	],

	/**
	 * admin/formviewer Titles
	 */
	[
		'key'		=> 'title.admin.formviewer',
		'label'		=> 'Form Viewer Page Title',
		'content'	=> "Form Viewer",
		'type'		=> $type,
		'section'	=> 'formviewer',
		'page'		=> 'view',
		'uri'		=> 'admin/formviewer'
	],

	/**
	 * admin/rank Page Titles
	 */
	[
		'key'		=> 'title.admin.ranks',
		'label'		=> 'Ranks Index Page Title',
		'content'	=> "Ranks",
		'type'		=> $type,
		'section'	=> 'rank',
		'page'		=> 'index',
		'uri'		=> 'admin/rank'
	],
	[
		'key'		=> 'title.admin.ranks.groups',
		'label'		=> 'Rank Groups Management Page Title',
		'content'	=> "Rank Groups",
		'type'		=> $type,
		'section'	=> 'rank',
		'page'		=> 'groups',
		'uri'		=> 'admin/rank/groups'
	],
	[
		'key'		=> 'title.admin.ranks.info',
		'label'		=> 'Rank Info Management Page Title',
		'content'	=> "Rank Info",
		'type'		=> $type,
		'section'	=> 'rank',
		'page'		=> 'info',
		'uri'		=> 'admin/rank/info'
	],
	[
		'key'		=> 'title.admin.ranks.manage',
		'label'		=> 'Rank Management Page Title',
		'content'	=> "Ranks",
		'type'		=> $type,
		'section'	=> 'rank',
		'page'		=> 'manage',
		'uri'		=> 'admin/rank/manage'
	],

	/**
	 * ARC Page Titles
	 */
	[
		'key'		=> 'title.admin.arc',
		'label'		=> 'ARC Index Page Title',
		'content'	=> "Application Review Center",
		'type'		=> $type,
		'section'	=> 'application',
		'page'		=> 'index',
		'uri'		=> 'admin/arc'
	],
	[
		'key'		=> 'title.admin.arc.rules',
		'label'		=> 'ARC Rules Page Title',
		'content'	=> "Application Review Rules",
		'type'		=> $type,
		'section'	=> 'application',
		'page'		=> 'rules',
		'uri'		=> 'admin/arc/rules'
	],
	[
		'key'		=> 'title.admin.arc.history',
		'label'		=> 'ARC History Page Title',
		'content'	=> "Application History",
		'type'		=> $type,
		'section'	=> 'application',
		'page'		=> 'history',
		'uri'		=> 'admin/arc/history'
	],
	[
		'key'		=> 'title.admin.arc.review',
		'label'		=> 'ARC Review Page Title',
		'content'	=> "Application Review",
		'type'		=> $type,
		'section'	=> 'application',
		'page'		=> 'review',
		'uri'		=> 'admin/arc/review'
	],

	/**
	 * admin/role Page Titles
	 */
	[
		'key'		=> 'title.admin.role',
		'label'		=> 'Access Roles Title',
		'content'	=> "Access Roles",
		'type'		=> $type,
		'section'	=> 'role',
		'page'		=> 'index',
		'uri'		=> 'admin/role'
	],
	[
		'key'		=> 'title.admin.role.tasks',
		'label'		=> 'Access Role Tasks Title',
		'content'	=> "Access Role Tasks",
		'type'		=> $type,
		'section'	=> 'role',
		'page'		=> 'tasks',
		'uri'		=> 'admin/role/tasks'
	],

	/**
	 * admin/catalog Titles
	 */
	[
		'key'		=> 'title.admin.catalog',
		'label'		=> 'Resource Catalogs Title',
		'content'	=> "Resource Catalogs",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'index',
		'uri'		=> 'admin/catalog'
	],
	[
		'key'		=> 'title.admin.catalog.ranks',
		'label'		=> 'Rank Sets Catalog Title',
		'content'	=> "Rank Sets",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'ranks',
		'uri'		=> 'admin/catalog/ranks'
	],
	[
		'key'		=> 'title.admin.catalog.skins',
		'label'		=> 'Skins Catalog Title',
		'content'	=> "Skins",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'skins',
		'uri'		=> 'admin/catalog/skins'
	],
	[
		'key'		=> 'title.admin.catalog.modules',
		'label'		=> 'Modules Catalog Title',
		'content'	=> "Modules",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'modules',
		'uri'		=> 'admin/catalog/modules'
	],
	[
		'key'		=> 'title.admin.catalog.widgets',
		'label'		=> 'Widgets Catalog Title',
		'content'	=> "Widgets",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'widgets',
		'uri'		=> 'admin/catalog/widgets'
	],

	/**
	 * admin/user Titles
	 */
	[
		'key'		=> 'title.admin.user.all',
		'label'		=> 'All Users Title',
		'content'	=> "Users",
		'type'		=> $type,
		'section'	=> 'user',
		'page'		=> 'users',
		'uri'		=> 'admin/user'
	],
	[
		'key'		=> 'title.admin.user.create',
		'label'		=> 'Create New User Title',
		'content'	=> "Create New User",
		'type'		=> $type,
		'section'	=> 'user',
		'page'		=> 'create',
		'uri'		=> 'admin/user/create'
	],
	[
		'key'		=> 'title.admin.user.edit',
		'label'		=> 'Edit User Title',
		'content'	=> "Edit User",
		'type'		=> $type,
		'section'	=> 'user',
		'page'		=> 'edit',
		'uri'		=> 'admin/user/edit'
	],
	[
		'key'		=> 'title.admin.user.loa',
		'label'		=> 'User LOA Title',
		'content'	=> "Request LOA",
		'type'		=> $type,
		'section'	=> 'user',
		'page'		=> 'loa',
		'uri'		=> 'admin/user/loa'
	],
	[
		'key'		=> 'title.admin.user.upload',
		'label'		=> 'User Image Upload Title',
		'content'	=> "Upload User Image",
		'type'		=> $type,
		'section'	=> 'user',
		'page'		=> 'uploadUserImage',
		'uri'		=> 'admin/user/upload'
	],
	[
		'key'		=> 'title.admin.user.avatar',
		'label'		=> 'User Avatar Crop Title',
		'content'	=> "Crop User Avatar",
		'type'		=> $type,
		'section'	=> 'user',
		'page'		=> 'userAvatar',
		'uri'		=> 'admin/user/avatar'
	],

	/**
	 * admin/manage Titles
	 */
	[
		'key'		=> 'title.admin.routes',
		'label'		=> 'Routes Manager Page Title',
		'content'	=> "Routes Manager",
		'type'		=> $type,
		'section'	=> 'manage',
		'page'		=> 'routes',
		'uri'		=> 'admin/routes'
	],
	[
		'key'		=> 'title.admin.manage.content',
		'label'		=> 'Manage Site Content Title',
		'content'	=> "Site Content",
		'type'		=> $type,
		'section'	=> 'manage',
		'page'		=> 'sitecontent',
		'uri'		=> 'admin/sitecontent'
	],

];