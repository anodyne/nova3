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
		'page'		=> 'index'
	],
	[
		'key'		=> 'title.login.reset',
		'label'		=> 'Reset Password Page Title',
		'content'	=> "Reset Password",
		'type'		=> $type,
		'section'	=> 'login',
		'page'		=> 'reset'
	],
	[
		'key'		=> 'title.login.reset_confirm',
		'label'		=> 'Confirm Reset Password Page Title',
		'content'	=> "Confirm Password Reset",
		'type'		=> $type,
		'section'	=> 'login',
		'page'		=> 'reset_confirm'
	],
	[
		'key'		=> 'title.login.logout',
		'label'		=> 'Logout Page Title',
		'content'	=> "Logout",
		'type'		=> $type,
		'section'	=> 'login',
		'page'		=> 'logout'
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
		'page'		=> 'index'
	],
	[
		'key'		=> 'title.main.credits',
		'label'		=> 'Site Credits Page Title',
		'content'	=> 'Site Credits',
		'type'		=> $type,
		'section'	=> 'main',
		'page'		=> 'credits'
	],
	[
		'key'		=> 'title.main.join',
		'label'		=> 'Join Page Title',
		'content'	=> 'Join',
		'type'		=> $type,
		'section'	=> 'main',
		'page'		=> 'join'
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
		'page'		=> 'index'
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
		'page'		=> 'index'
	],
	[
		'key'		=> 'title.admin.routes',
		'label'		=> 'Routes Manager Page Title',
		'content'	=> "Routes Manager",
		'type'		=> $type,
		'section'	=> 'admin',
		'page'		=> 'routes'
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
		'page'		=> 'index'
	],
	[
		'key'		=> 'title.admin.form.fields',
		'label'		=> 'Form Field Management Page Title',
		'content'	=> "Form Fields",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'fields'
	],
	[
		'key'		=> 'title.admin.form.sections',
		'label'		=> 'Form Section Management Page Title',
		'content'	=> "Form Sections",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'sections'
	],
	[
		'key'		=> 'title.admin.form.tabs',
		'label'		=> 'Form Tab Management Page Title',
		'content'	=> "Form Tabs",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'tabs'
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
		'page'		=> 'view'
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
		'page'		=> 'index'
	],
	[
		'key'		=> 'title.admin.ranks.groups',
		'label'		=> 'Rank Groups Management Page Title',
		'content'	=> "Rank Groups",
		'type'		=> $type,
		'section'	=> 'rank',
		'page'		=> 'groups'
	],
	[
		'key'		=> 'title.admin.ranks.info',
		'label'		=> 'Rank Info Management Page Title',
		'content'	=> "Rank Info",
		'type'		=> $type,
		'section'	=> 'rank',
		'page'		=> 'info'
	],
	[
		'key'		=> 'title.admin.ranks.manage',
		'label'		=> 'Rank Management Page Title',
		'content'	=> "Ranks",
		'type'		=> $type,
		'section'	=> 'rank',
		'page'		=> 'manage'
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
		'page'		=> 'index'
	],
	[
		'key'		=> 'title.admin.arc.rules',
		'label'		=> 'ARC Rules Page Title',
		'content'	=> "Application Review Rules",
		'type'		=> $type,
		'section'	=> 'application',
		'page'		=> 'rules'
	],
	[
		'key'		=> 'title.admin.arc.history',
		'label'		=> 'ARC History Page Title',
		'content'	=> "Application History",
		'type'		=> $type,
		'section'	=> 'application',
		'page'		=> 'history'
	],
	[
		'key'		=> 'title.admin.arc.review',
		'label'		=> 'ARC Review Page Title',
		'content'	=> "Application Review",
		'type'		=> $type,
		'section'	=> 'application',
		'page'		=> 'review'
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
		'page'		=> 'index'
	],
	[
		'key'		=> 'title.admin.role.tasks',
		'label'		=> 'Access Role Tasks Title',
		'content'	=> "Access Role Tasks",
		'type'		=> $type,
		'section'	=> 'role',
		'page'		=> 'tasks'
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
		'page'		=> 'index'
	],
	[
		'key'		=> 'title.admin.catalog.ranks',
		'label'		=> 'Rank Sets Catalog Title',
		'content'	=> "Rank Sets",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'ranks'
	],
	[
		'key'		=> 'title.admin.catalog.skins',
		'label'		=> 'Skins Catalog Title',
		'content'	=> "Skins",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'skins'
	],
	[
		'key'		=> 'title.admin.catalog.modules',
		'label'		=> 'Modules Catalog Title',
		'content'	=> "Modules",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'modules'
	],
	[
		'key'		=> 'title.admin.catalog.widgets',
		'label'		=> 'Widgets Catalog Title',
		'content'	=> "Widgets",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'widgets'
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
		'page'		=> 'all'
	],
	[
		'key'		=> 'title.admin.user.create',
		'label'		=> 'Create New User Title',
		'content'	=> "Create New User",
		'type'		=> $type,
		'section'	=> 'user',
		'page'		=> 'create'
	],
	[
		'key'		=> 'title.admin.user.edit',
		'label'		=> 'Edit User Title',
		'content'	=> "Edit User",
		'type'		=> $type,
		'section'	=> 'user',
		'page'		=> 'edit'
	],
	[
		'key'		=> 'title.admin.user.loa',
		'label'		=> 'User LOA Title',
		'content'	=> "Request LOA",
		'type'		=> $type,
		'section'	=> 'user',
		'page'		=> 'loa'
	],

	/**
	 * admin/manage Titles
	 */
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