<?php

/**
 * Site Content - Messages
 */

$type = 'message';

return [

	/**
	 * Login Messages
	 */
	[
		'key'		=> 'message.login.reset',
		'label'		=> 'Reset Password Message',
		'content'	=> "To reset your password, enter your email address below. You'll receive an email with a link to confirm your password reset. If you log in to the site before confirming your password reset, the reset will be cancelled.",
		'type'		=> $type,
		'section'	=> 'login',
		'page'		=> 'reset',
		'protected'	=> (int) true
	],
	[
		'key'		=> 'message.login.reset_confirm',
		'label'		=> 'Confirm Reset Password Message',
		'content'	=> "The second step of the password reset process is confirmation. In order to complete your password reset, simply enter a new password and hit Submit. If you did not request a password reset, you can simply log in to the site to cancel the reset request.",
		'type'		=> $type,
		'section'	=> 'login',
		'page'		=> 'reset_confirm',
		'protected'	=> (int) true
	],

	/**
	 * Main Messages
	 */
	[
		'key'		=> 'message.main',
		'label'		=> 'Main Page Message',
		'content'	=> "Define your welcome message and welcome page header through the Site Content page.",
		'type'		=> $type,
		'section'	=> 'main',
		'page'		=> 'index'
	],
	[
		'key'		=> 'message.main.credits',
		'label'		=> 'Credits',
		'content'	=> "Define your site credits through the Site Messages page.",
		'type'		=> $type,
		'section'	=> 'main',
		'page'		=> 'credits'
	],
	[
		'key'		=> 'message.main.join',
		'label'		=> 'Join Message',
		'content'	=> "Define your join message through the Site Messages page.",
		'type'		=> $type,
		'section'	=> '',
		'page'		=> ''
	],

	/**
	 * Sim Messages
	 */
	[
		'key'		=> 'message.sim',
		'label'		=> 'Sim Message',
		'content'	=> "Define your sim message through the Site Content page.",
		'type'		=> $type,
		'section'	=> 'sim',
		'page'		=> 'index'
	],

	/**
	 * Personnel Messages
	 */

	/**
	 * admin/main Messages
	 */
	[
		'key'		=> 'message.admin',
		'label'		=> 'ACP Message',
		'content'	=> "Define your admin control panel through the Site Content page.",
		'type'		=> $type,
		'section'	=> 'admin',
		'page'		=> 'index'
	],
	[
		'key'		=> 'message.admin.routes',
		'label'		=> 'Routes Manager Message',
		'content'	=> "Routes are the way Nova knows what to do when a specific URI is called. All of Nova's routes can be managed from this page. Routes specified as core routes cannot be edited directly, but you can duplicate them and edit your duplicate to point to a different resource. Doing so will tell Nova that you want a specific URI to use a different resource than what's in the core.",
		'type'		=> $type,
		'section'	=> 'admin',
		'page'		=> 'routes'
	],
	[
		'key'		=> 'message.admin.routes.create',
		'label'		=> 'Create Route Message',
		'content'	=> "",
		'type'		=> $type,
		'section'	=> 'admin',
		'page'		=> 'routes',
		'mode'		=> 'create'
	],
	[
		'key'		=> 'message.admin.routes.edit',
		'label'		=> 'Edit Route Message',
		'content'	=> "",
		'type'		=> $type,
		'section'	=> 'admin',
		'page'		=> 'routes',
		'mode'		=> 'update'
	],

	/**
	 * admin/form Messages
	 */
	[
		'key'		=> 'message.admin.form.tabs',
		'label'		=> 'Manage Form Tabs Message',
		'content'	=> "You can edit any tab attached to this form by using the options below. If you want to change the order the tabs appear in, simply drag-and-drop the row to where you want it.",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'tabs'
	],
	[
		'key'		=> 'message.admin.form.tabs.create',
		'label'		=> 'Create Form Tab Message',
		'content'	=> "",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'tabs',
		'mode'		=> 'create'
	],
	[
		'key'		=> 'message.admin.form.tabs.edit',
		'label'		=> 'Edit Form Tab Message',
		'content'	=> "",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'tabs',
		'mode'		=> 'update'
	],
	[
		'key'		=> 'message.admin.form.sections',
		'label'		=> 'Manage Form Sections Message',
		'content'	=> "You can edit any section attached to this form by using the options below. If you want to change the order the sections appear in, simply drag-and-drop the row to where you want it. Sections cannot be moved between tabs using the drag-and-drop method. You will need to edit the section and change the attached tab from the edit screen.",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'sections'
	],
	[
		'key'		=> 'message.admin.form.sections.create',
		'label'		=> 'Create Form Section Message',
		'content'	=> "",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'sections',
		'mode'		=> 'create'
	],
	[
		'key'		=> 'message.admin.form.sections.edit',
		'label'		=> 'Edit Form Section Message',
		'content'	=> "",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'sections',
		'mode'		=> 'update'
	],
	[
		'key'		=> 'message.admin.form.fields',
		'label'		=> 'Manage Form Fields Message',
		'content'	=> "You can edit any field attached to this form by using the options below. If you want to change the order the fields appear in, simply drag-and-drop the row to where you want it. Fields cannot be moved between sections using the drag-and-drop method. You will need to edit the field and change the attached section from the edit screen.",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'fields'
	],
	[
		'key'		=> 'message.admin.form.fields.create',
		'label'		=> 'Create Form Field Message',
		'content'	=> "",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'fields',
		'mode'		=> 'create'
	],
	[
		'key'		=> 'message.admin.form.fields.edit',
		'label'		=> 'Edit Form Field Message',
		'content'	=> "",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'fields',
		'mode'		=> 'update'
	],

	/**
	 * admin/rank Messages
	 */
	[
		'key'		=> 'message.admin.ranks.groups',
		'label'		=> 'Manage Rank Groups Message',
		'content'	=> "Rank groups are a simple way to organize ranks into logical groupings. Every rank in the system belongs to a rank group, allowing admins to easily add new groups of ranks. Nova comes with several rank groups already, but you can easily create new groups and add ranks to them from rank management.",
		'type'		=> $type,
		'section'	=> 'rank',
		'page'		=> 'groups'
	],
	[
		'key'		=> 'message.admin.ranks.info',
		'label'		=> 'Manage Rank Info Message',
		'content'	=> "Rank info contains all of the basic information about ranks that's repeated across multiple ranks, like name, short name, and order. Every rank in the system references one of the rank info records below, meaning that several ranks can be updated simultaneously by changing one of the info records. You can easily create new info records and use them with ranks or edit existing items.",
		'type'		=> $type,
		'section'	=> 'rank',
		'page'		=> 'info'
	],
	[
		'key'		=> 'message.admin.ranks.manage',
		'label'		=> 'Manage Ranks Message',
		'content'	=> "Ranks are made up of several different componets to keep things as flexible as possible. The ranks records below are composed of a rank info, a rank group, a base image, and a pip image. From here, you can change any and all of those pieces to customize your ranks to your liking.",
		'type'		=> $type,
		'section'	=> 'rank',
		'page'		=> 'manage'
	],

	/**
	 * ARC Messages
	 */
	[
		'key'		=> 'message.admin.arc',
		'label'		=> 'ARC Index Message',
		'content'	=> "",
		'type'		=> $type,
		'section'	=> 'application',
		'page'		=> 'index'
	],
	[
		'key'		=> 'message.admin.arc.rules',
		'label'		=> 'ARC Rules Message',
		'content'	=> "Application review rules are a way to automatically add specific users or users who hold specific positions to a review when an application is received. You can create as many rules as you want that will be evaluated and run on every new application. Rules whose conditions cannot be met will be ignored.",
		'type'		=> $type,
		'section'	=> 'application',
		'page'		=> 'rules'
	],

	/**
	 * admin/role Messages
	 */
	[
		'key'		=> 'message.admin.role',
		'label'		=> 'Access Roles Message',
		'content'	=> "Access roles control exactly what a user can and can't do in Nova. Some sensible defaults are included for managing your users, but you're free to create and edit these roles to fit your own game. Be careful when editing or deleting existing roles as doing so could prevent you or others from accessing areas of Nova.",
		'type'		=> $type,
		'section'	=> 'role',
		'page'		=> 'index'
	],
	[
		'key'		=> 'message.admin.role.create',
		'label'		=> 'Create Access Roles Message',
		'content'	=> "",
		'type'		=> $type,
		'section'	=> 'role',
		'page'		=> 'index',
		'mode'		=> 'create'
	],
	[
		'key'		=> 'message.admin.role.edit',
		'label'		=> 'Edit Access Roles Message',
		'content'	=> "",
		'type'		=> $type,
		'section'	=> 'role',
		'page'		=> 'index',
		'mode'		=> 'update'
	],
	[
		'key'		=> 'message.admin.role.tasks',
		'label'		=> 'Access Roles Tasks Message',
		'content'	=> "Access roles are made up of tasks. Each task defines something a user can do such as creating, updating, deleting or even seeing entries. When combined with a component, this system allows for granular control over what a user can and can't do in Nova. You can edit any task in the system or even create your own for your own pages or MODs. Be careful when editing or deleting existing items as doing so could prevent you or others from accessing areas of Nova.",
		'type'		=> $type,
		'section'	=> 'role',
		'page'		=> 'tasks'
	],
	[
		'key'		=> 'message.admin.role.tasks.create',
		'label'		=> 'Create Access Roles Tasks Message',
		'content'	=> "",
		'type'		=> $type,
		'section'	=> 'role',
		'page'		=> 'tasks',
		'mode'		=> 'create'
	],
	[
		'key'		=> 'message.admin.role.tasks.edit',
		'label'		=> 'Edit Access Roles Tasks Message',
		'content'	=> "",
		'type'		=> $type,
		'section'	=> 'role',
		'page'		=> 'tasks',
		'mode'		=> 'update'
	],

	/**
	 * admin/catalog Messages
	 */
	[
		'key'		=> 'message.admin.catalog',
		'label'		=> 'Resource Catalogs Message',
		'content'	=> "Resource Catalogs allow you to manage the various resources available throughout Nova such as skins, rank sets, modules and widgets.",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'index'
	],

	/**
	 * admin/user Messages
	 */
	[
		'key'		=> 'message.admin.user.all.create',
		'label'		=> 'New User Message',
		'content'	=> "You can create a new user using the fields below. The password you enter will be emailed to the user. The user should change the password to something of their own choosing as soon as the log in the first time!",
		'type'		=> $type,
		'section'	=> 'user',
		'page'		=> 'create'
	],
	[
		'key'		=> 'message.admin.user.loa',
		'label'		=> 'User LOA Message',
		'content'	=> "",
		'type'		=> $type,
		'section'	=> 'user',
		'page'		=> 'loa'
	],

	/**
	 * Others
	 */
	[
		'key'		=> 'other.credits',
		'label'		=> 'Permanent Credits',
		'content'	=> "The Nova 3 experience can be summed up as \"smarter and better\". From the top down, Nova is faster, simpler, smarter and more flexible than before. This is accomplished in no small part by the elegant and powerful PHP 5.3 foundation of <a href='http://laravel.com/' target='.blank'>Laravel</a>. The icons found throughout Nova are from the <a href='http://icomoon.io/' target='.blank'>IcoMoon</a> icon font.",
		'protected' => (int) true,
		'type'		=> 'other'
	],
	[
		'key'		=> 'other.footer',
		'label'		=> 'Additional Footer Information',
		'content'	=> "New to Nova 3 is the ability to add additional information to the footer, like banner exchanges, without having to edit any files. Just plug your code/message into the 'Additional Footer Information' site content item!",
		'type'		=> 'other'
	],
	[
		'key'		=> 'other.join',
		'label'		=> 'Join Disclaimer',
		'content'	=> "Members are expected to follow the rules and regulations of both the sim and fleet at all times, both in character and out of character. By continuing, you affirm that you will sim in a proper and adequate manner. Members who choose to make ultra short posts, post very infrequently, or post posts with explicit content (above PG-13) will be removed immediately, and by continuing, you agree to this. In addition, in compliance with the Children's Online Privacy Protection Act of 1998 (COPPA
	], we do not accept players under the age of 13.  Any players found to be under the age of 13 will be immediately removed without question.  By agreeing to these terms, you are also saying that you are above the age of 13.",
		'type'		=> 'other'
	],
	[
		'key'		=> 'other.join_sample',
		'label'		=> 'Join Sample Post',
		'content'	=> "Define your join sample post through the Site Content page. If you don't want to use a sample post, simply leave this blank.",
		'type'		=> 'other'
	],
	[
		'key'		=> 'other.join_character',
		'label'		=> 'Join Character Help',
		'content'	=> "__Tips for a good character application:__

* Be unique. No one likes interacting with a character that can do everything perfectly. Look for ways to make your character fresh and exciting and to give them shortcomings and weaknesses.
* A character isn't his/her position, but a person with a job. Before they work here, they started somewhere. In this sense, their past has defined their arrival to this place and defined who they are. What brought the character here? There should be a logical reason the character is in the here-and-now of the game situation.
* A character fits into the world in a specific way. They were born somewhere and are a product of their time (war, poverty, disease, prosperity, etc.). Use those factors to craft a narrative about the character.
* Many people choose to use exaggerated aspects of their own personality (as well as a complimentary weakness). Doing so will make it easier to write the character because you know how you would react in given situations.",
		'type'		=> 'other'
	],

];