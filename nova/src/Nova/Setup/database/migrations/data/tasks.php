<?php

return [
	/**
	 * Messages Actions
	 */
	[
		'action' => 'create',
		'component' => 'messages',
		'level' => 0,
		'name' => 'Write Messages',
		'desc' => 'Write and send messages to other users.'
	],
	[
		'action' => 'read',
		'component' => 'messages',
		'level' => 0,
		'name' => 'Read Messages',
		'desc' => 'Read your own messages.'
	],
	[
		'action' => 'delete',
		'component' => 'messages',
		'level' => 0,
		'name' => 'Delete Messages',
		'desc' => 'Delete your own messages.'
	],
	
	/**
	 * User Actions
	 */
	[
		'action' => 'create',
		'component' => 'user',
		'level' => 0,
		'name' => 'Create User',
		'desc' => ''
	],
	[
		'action' => 'update',
		'component' => 'user',
		'level' => 1,
		'name' => 'Edit User (Level 1)',
		'desc' => 'Update your own user account.'
	],
	[
		'action' => 'update',
		'component' => 'user',
		'level' => 2,
		'name' => 'Edit User (Level 2)',
		'desc' => 'Update any user account.'
	],
	[
		'action' => 'delete',
		'component' => 'user',
		'level' => 0,
		'name' => 'Delete User',
		'desc' => 'Delete users.'
	],

	/**
	 * Character Actions
	 */
	[
		'action' => 'create',
		'component' => 'character',
		'level' => 1,
		'name' => 'Create Character (Level 1)',
		'desc' => 'Create a new character.'
	],
	[
		'action' => 'create',
		'component' => 'character',
		'level' => 2,
		'name' => 'Create Character (Level 2)',
		'desc' => 'Create a new character and accept or reject new applications.'
	],
	[
		'action' => 'update',
		'component' => 'character',
		'level' => 1,
		'name' => 'Edit Character (Level 1)',
		'desc' => 'Update your own character(s) bio.'
	],
	[
		'action' => 'update',
		'component' => 'character',
		'level' => 2,
		'name' => 'Edit Character (Level 2)',
		'desc' => 'Update any non-assigned character bio.'
	],
	[
		'action' => 'update',
		'component' => 'character',
		'level' => 3,
		'name' => 'Edit Character (Level 3)',
		'desc' => 'Update any character bio and assign users to a character.'
	],
	[
		'action' => 'delete',
		'component' => 'character',
		'level' => 0,
		'name' => 'Delete Character',
		'desc' => 'Delete characters. Any character who has content associated with them (posts, logs, announcements) cannot be deleted.'
	],

	/**
	 * Mission Post Actions
	 */
	[
		'action' => 'create',
		'component' => 'post',
		'level' => 0,
		'name' => 'Create Post',
		'desc' => ''
	],
	[
		'action' => 'read',
		'component' => 'post',
		'level' => 1,
		'name' => 'View Mission Posts (Level 1)',
		'desc' => 'See your own non-activated mission posts.'
	],
	[
		'action' => 'read',
		'component' => 'post',
		'level' => 2,
		'name' => 'View Mission Posts (Level 2)',
		'desc' => 'See all non-activated mission posts.'
	],
	[
		'action' => 'update',
		'component' => 'post',
		'level' => 1,
		'name' => 'Edit Post (Level 1)',
		'desc' => 'Update your own mission posts.'
	],
	[
		'action' => 'update',
		'component' => 'post',
		'level' => 2,
		'name' => 'Edit Post (Level 2)',
		'desc' => 'Update any mission post.'
	],
	[
		'action' => 'delete',
		'component' => 'post',
		'level' => 0,
		'name' => 'Delete Post',
		'desc' => ''
	],

	/**
	 * Personal Log Actions
	 */
	[
		'action' => 'create',
		'component' => 'log',
		'level' => 0,
		'name' => 'Create Log',
		'desc' => ''
	],
	[
		'action' => 'read',
		'component' => 'log',
		'level' => 1,
		'name' => 'View Personal Logs (Level 1)',
		'desc' => 'See your own non-activated personal logs.'
	],
	[
		'action' => 'read',
		'component' => 'log',
		'level' => 2,
		'name' => 'View Personal Logs (Level 2)',
		'desc' => 'See all non-activated personal logs.'
	],
	[
		'action' => 'update',
		'component' => 'log',
		'level' => 1,
		'name' => 'Edit Log (Level 1)',
		'desc' => 'Update your own personal logs.'
	],
	[
		'action' => 'update',
		'component' => 'log',
		'level' => 2,
		'name' => 'Edit Log (Level 2)',
		'desc' => 'Update any personal log.'
	],
	[
		'action' => 'delete',
		'component' => 'log',
		'level' => 0,
		'name' => 'Delete Log',
		'desc' => ''
	],

	/**
	 * Announcement Actions
	 */
	[
		'action' => 'create',
		'component' => 'announcement',
		'level' => 0,
		'name' => 'Create Announcement',
		'desc' => ''
	],
	[
		'action' => 'read',
		'component' => 'announcement',
		'level' => 1,
		'name' => 'View Announcements (Level 1)',
		'desc' => 'See your own non-activated announcements.'
	],
	[
		'action' => 'read',
		'component' => 'announcement',
		'level' => 2,
		'name' => 'View Announcements (Level 2)',
		'desc' => 'See all non-activated announcements.'
	],
	[
		'action' => 'update',
		'component' => 'announcement',
		'level' => 1,
		'name' => 'Edit Announcement (Level 1)',
		'desc' => 'Update your own announcements.'
	],
	[
		'action' => 'update',
		'component' => 'announcement',
		'level' => 2,
		'name' => 'Edit Announcement (Level 2)',
		'desc' => 'Update any announcement.'
	],
	[
		'action' => 'delete',
		'component' => 'announcement',
		'level' => 0,
		'name' => 'Delete Announcement',
		'desc' => ''
	],

	/**
	 * Comment Actions
	 */
	[
		'action' => 'create',
		'component' => 'comment',
		'level' => 0,
		'name' => 'Create Comment',
		'desc' => ''
	],
	[
		'action' => 'update',
		'component' => 'comment',
		'level' => 0,
		'name' => 'Edit Comment',
		'desc' => ''
	],
	[
		'action' => 'delete',
		'component' => 'comment',
		'level' => 0,
		'name' => 'Delete Comment',
		'desc' => ''
	],

	/**
	 * Report Actions
	 */
	[
		'action' => 'read',
		'component' => 'reports',
		'level' => 1,
		'name' => 'View Reports (Level 1)',
		'desc' => 'See the sim stats and milestone reports.'
	],
	[
		'action' => 'read',
		'component' => 'reports',
		'level' => 2,
		'name' => 'View Reports (Level 2)',
		'desc' => 'See the crew activity and posting reports as well as all level 1 reports.'
	],
	[
		'action' => 'read',
		'component' => 'reports',
		'level' => 3,
		'name' => 'View Reports (Level 3)',
		'desc' => 'See the LOA and award nomination reports as well as all level 1 and 2 reports.'
	],
	[
		'action' => 'read',
		'component' => 'reports',
		'level' => 4,
		'name' => 'View Reports (Level 4)',
		'desc' => 'See all reports.'
	],

	/**
	 * Ban Actions
	 */
	[
		'action' => 'create',
		'component' => 'ban',
		'level' => 0,
		'name' => 'Create Ban',
		'desc' => ''
	],
	[
		'action' => 'update',
		'component' => 'ban',
		'level' => 0,
		'name' => 'Edit Ban',
		'desc' => ''
	],
	[
		'action' => 'delete',
		'component' => 'ban',
		'level' => 0,
		'name' => 'Delete Ban',
		'desc' => ''
	],

	/**
	 * Position Actions
	 */
	[
		'action' => 'create',
		'component' => 'position',
		'level' => 0,
		'name' => 'Create Position',
		'desc' => ''
	],
	[
		'action' => 'update',
		'component' => 'position',
		'level' => 0,
		'name' => 'Edit Position',
		'desc' => ''
	],
	[
		'action' => 'delete',
		'component' => 'position',
		'level' => 0,
		'name' => 'Delete Position',
		'desc' => ''
	],

	/**
	 * Rank Actions
	 */
	[
		'action' => 'create',
		'component' => 'rank',
		'level' => 0,
		'name' => 'Create Rank',
		'desc' => ''
	],
	[
		'action' => 'update',
		'component' => 'rank',
		'level' => 0,
		'name' => 'Edit Rank',
		'desc' => ''
	],
	[
		'action' => 'delete',
		'component' => 'rank',
		'level' => 0,
		'name' => 'Delete Rank',
		'desc' => ''
	],

	/**
	 * Department Actions
	 */
	[
		'action' => 'create',
		'component' => 'department',
		'level' => 0,
		'name' => 'Create Department',
		'desc' => ''
	],
	[
		'action' => 'update',
		'component' => 'department',
		'level' => 0,
		'name' => 'Edit Department',
		'desc' => ''
	],
	[
		'action' => 'delete',
		'component' => 'department',
		'level' => 0,
		'name' => 'Delete Department',
		'desc' => ''
	],

	/**
	 * Catalog Actions
	 */
	[
		'action' => 'create',
		'component' => 'catalog',
		'level' => 0,
		'name' => 'Create Catalog',
		'desc' => ''
	],
	[
		'action' => 'update',
		'component' => 'catalog',
		'level' => 0,
		'name' => 'Edit Catalog',
		'desc' => ''
	],
	[
		'action' => 'delete',
		'component' => 'catalog',
		'level' => 0,
		'name' => 'Delete Catalog',
		'desc' => ''
	],

	/**
	 * Form Actions
	 */
	[
		'action' => 'create',
		'component' => 'form',
		'level' => 0,
		'name' => 'Create Form',
		'desc' => ''
	],
	[
		'action' => 'update',
		'component' => 'form',
		'level' => 0,
		'name' => 'Edit Form',
		'desc' => ''
	],
	[
		'action' => 'delete',
		'component' => 'form',
		'level' => 0,
		'name' => 'Delete Form',
		'desc' => ''
	],
	[
		'action' => 'read',
		'component' => 'form',
		'level' => 0,
		'name' => 'Read Form',
		'desc' => 'See any entries submitted for non-protected forms.'
	],

	/**
	 * Navigation Actions
	 */
	[
		'action' => 'create',
		'component' => 'nav',
		'level' => 0,
		'name' => 'Create Navigation Item',
		'desc' => ''
	],
	[
		'action' => 'update',
		'component' => 'nav',
		'level' => 0,
		'name' => 'Edit Navigation',
		'desc' => ''
	],
	[
		'action' => 'delete',
		'component' => 'nav',
		'level' => 0,
		'name' => 'Delete Navigation Item',
		'desc' => ''
	],

	/**
	 * Role Actions
	 */
	[
		'action' => 'create',
		'component' => 'role',
		'level' => 0,
		'name' => 'Create Access Role',
		'desc' => ''
	],
	[
		'action' => 'update',
		'component' => 'role',
		'level' => 0,
		'name' => 'Edit Access Role',
		'desc' => ''
	],
	[
		'action' => 'delete',
		'component' => 'role',
		'level' => 0,
		'name' => 'Delete Access Role',
		'desc' => ''
	],

	/**
	 * Content Actions
	 */
	[
		'action' => 'create',
		'component' => 'content',
		'level' => 0,
		'name' => 'Create Content',
		'desc' => 'Create new site content to be used by Nova.'
	],
	[
		'action' => 'update',
		'component' => 'content',
		'level' => 0,
		'name' => 'Edit Content',
		'desc' => 'Edit any site content message.'
	],
	[
		'action' => 'delete',
		'component' => 'content',
		'level' => 0,
		'name' => 'Delete Content',
		'desc' => ''
	],

	/**
	 * Settings Actions
	 */
	[
		'action' => 'create',
		'component' => 'settings',
		'level' => 0,
		'name' => 'Create Setting',
		'desc' => 'Create a new setting for use throughout Nova.'
	],
	[
		'action' => 'update',
		'component' => 'settings',
		'level' => 0,
		'name' => 'Edit Setting',
		'desc' => 'Edit any setting in the system, including user-created settings.'
	],
	[
		'action' => 'delete',
		'component' => 'settings',
		'level' => 0,
		'name' => 'Delete Setting',
		'desc' => 'Delete any user-created setting.'
	],

	/**
	 * Pages (Routes) Actions
	 */
	[
		'action' => 'create',
		'component' => 'routes',
		'level' => 0,
		'name' => 'Create Route',
		'desc' => 'Create new routes and duplicating core routes for editing.'
	],
	[
		'action' => 'update',
		'component' => 'routes',
		'level' => 0,
		'name' => 'Edit Route',
		'desc' => 'Edit any routes that have been created or duplicated.'
	],
	[
		'action' => 'delete',
		'component' => 'routes',
		'level' => 0,
		'name' => 'Delete Route',
		'desc' => 'Remote a user-created route and fallback to the core route.'
	],
];