<?php

use Illuminate\Database\Migrations\Migration;

class CreateRoles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('roles', function($table)
		{
			$table->increments('id');
			$table->string('name')->nullable();
			$table->text('desc')->nullable();
			$table->text('inherits')->nullable();
		});

		Schema::create('roles_tasks', function($table)
		{
			$table->increments('id');
			$table->integer('role_id');
			$table->integer('task_id');
		});

		Schema::create('tasks', function($table)
		{
			$table->increments('id');
			$table->string('component', 100)->nullable();
			$table->string('action', 11)->default('read');
			$table->boolean('level')->default(0);
			$table->string('label')->nullable();
			$table->string('help')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('roles');
		Schema::drop('roles_tasks');
		Schema::drop('tasks');
	}

	protected function seed()
	{
		$this->seedRoles();
		$this->seedRoleTasks();
		$this->seedTasks();
	}

	protected function seedRoles()
	{
		$data = array(
			array(
				'name' => 'Inactive User',
				'desc' => "Inactive users have no privileges within the system. This role is automatically assigned to any user with who has been retired.",
				'inherits' => ''),
			array(
				'name' => 'User',
				'desc' => "Every user in the system starts with these permissions. This role is automatically assigned to any user who is not retired.",
				'inherits' => ''),
			array(
				'name' => 'Active User',
				'desc' => "Every active user in the system has these permissions.",
				'inherits' => '2'),
			array(
				'name' => 'Power User',
				'desc' => "Power users are given more access to pieces of the system to help them assist the game master as necessary.",
				'inherits' => '2,3'),
			array(
				'name' => 'Administrator',
				'desc' => "Like power users, administrators are given higher permissions to the system to help them assist the game master as necessary.",
				'inherits' => '2,3,4'),
			array(
				'name' => 'System Administrator',
				'desc' => "System administrators have complete control over the system. This role should only be assigned to a select few individuals who are trusted to run the game.",
				'inherits' => '2,3,4,5'),
		);

		foreach ($data as $value)
		{
			DB::table('roles')->insert($value);
		}
	}

	protected function seedRoleTasks()
	{
		$data = array(
			2 => array(1, 2, 3, 6),
			3 => array(14, 11, 18, 23, 33, 9, 20, 25, 88, 90, 37),
			4 => array(91, 12, 15, 28, 38),
			5 => array(21, 26, 31, 92, 94, 16, 17, 13, 7, 35, 36, 39),
			6 => array(4, 5, 8, 10, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 89),
		);

		foreach ($data as $key => $value)
		{
			foreach ($value as $task)
			{
				DB::table('roles_tasks')->insert(array('role_id' => $key, 'task_id' => $task));
			}
		}
	}

	protected function seedTasks()
	{
		$data = array(
			/**
			 * Messages Actions
			 */
			array(
				'action' => 'create',
				'component' => 'messages',
				'level' => 0,
				'label' => 'Write Messages',
				'help' => 'Write and send messages to other users.'),
			array(
				'action' => 'read',
				'component' => 'messages',
				'level' => 0,
				'label' => 'Read Messages',
				'help' => 'Read own messages.'),
			array(
				'action' => 'delete',
				'component' => 'messages',
				'level' => 0,
				'label' => 'Delete Messages',
				'help' => 'Delete own messages.'),
			
			/**
			 * User Actions
			 */
			array(
				'action' => 'create',
				'component' => 'user',
				'level' => 0,
				'label' => 'Create User',
				'help' => ''),
			array(
				'action' => 'read',
				'component' => 'user',
				'level' => 0,
				'label' => 'View All Users',
				'help' => ''),
			array(
				'action' => 'update',
				'component' => 'user',
				'level' => 1,
				'label' => 'Edit User (Level 1)',
				'help' => 'Update own user account.'),
			array(
				'action' => 'update',
				'component' => 'user',
				'level' => 2,
				'label' => 'Edit User (Level 2)',
				'help' => 'Update any user account.'),
			array(
				'action' => 'delete',
				'component' => 'user',
				'level' => 0,
				'label' => 'Delete User',
				'help' => 'User accounts associated with a character who has content associated with their account (posts, logs, announcements) cannot be deleted.'),

			/**
			 * Character Actions
			 */
			array(
				'action' => 'create',
				'component' => 'character',
				'level' => 1,
				'label' => 'Create Character (Level 1)',
				'help' => 'Create a new non-playing character.'),
			array(
				'action' => 'create',
				'component' => 'character',
				'level' => 2,
				'label' => 'Create Character (Level 2)',
				'help' => 'Create a new character (playing and non-playing) and accept or reject new characters.'),
			array(
				'action' => 'read',
				'component' => 'character',
				'level' => 1,
				'label' => 'View Characters',
				'help' => 'See all characters associated with their account.'),
			array(
				'action' => 'read',
				'component' => 'character',
				'level' => 2,
				'label' => 'View Non-Playing Characters',
				'help' => 'See all non-playing characters.'),
			array(
				'action' => 'read',
				'component' => 'character',
				'level' => 3,
				'label' => 'View All Characters',
				'help' => 'See all characters.'),
			array(
				'action' => 'update',
				'component' => 'character',
				'level' => 1,
				'label' => 'Edit Character (Level 1)',
				'help' => 'Update own character(s) bio.'),
			array(
				'action' => 'update',
				'component' => 'character',
				'level' => 2,
				'label' => 'Edit Character (Level 2)',
				'help' => 'Update any non-playing character bio.'),
			array(
				'action' => 'update',
				'component' => 'character',
				'level' => 3,
				'label' => 'Edit Character (Level 3)',
				'help' => 'Update any character bio.'),
			array(
				'action' => 'delete',
				'component' => 'character',
				'level' => 0,
				'label' => 'Delete Character',
				'help' => 'Characters who have content (posts, logs, announcements, etc.) cannot be deleted.'),

			/**
			 * Mission Post Actions
			 */
			array(
				'action' => 'create',
				'component' => 'post',
				'level' => 0,
				'label' => 'Create Post',
				'help' => ''),
			array(
				'action' => 'read',
				'component' => 'post',
				'level' => 0,
				'label' => 'View Mission Posts',
				'help' => 'See all non-activated mission posts.'),
			array(
				'action' => 'update',
				'component' => 'post',
				'level' => 1,
				'label' => 'Edit Post (Level 1)',
				'help' => 'Update own mission posts.'),
			array(
				'action' => 'update',
				'component' => 'post',
				'level' => 2,
				'label' => 'Edit Post (Level 2)',
				'help' => 'Update any mission post.'),
			array(
				'action' => 'delete',
				'component' => 'post',
				'level' => 0,
				'label' => 'Delete Post',
				'help' => ''),

			/**
			 * Personal Log Actions
			 */
			array(
				'action' => 'create',
				'component' => 'log',
				'level' => 0,
				'label' => 'Create Log',
				'help' => ''),
			array(
				'action' => 'read',
				'component' => 'log',
				'level' => 0,
				'label' => 'View Personal Logs',
				'help' => 'See all non-activated personal logs.'),
			array(
				'action' => 'update',
				'component' => 'log',
				'level' => 1,
				'label' => 'Edit Log (Level 1)',
				'help' => 'Update own personal logs.'),
			array(
				'action' => 'update',
				'component' => 'log',
				'level' => 2,
				'label' => 'Edit Log (Level 2)',
				'help' => 'Update any personal log.'),
			array(
				'action' => 'delete',
				'component' => 'log',
				'level' => 0,
				'label' => 'Delete Log',
				'help' => ''),

			/**
			 * Announcement Actions
			 */
			array(
				'action' => 'create',
				'component' => 'announcement',
				'level' => 0,
				'label' => 'Create Announcement',
				'help' => ''),
			array(
				'action' => 'read',
				'component' => 'announcement',
				'level' => 0,
				'label' => 'View Announcements',
				'help' => 'See all non-activated announcements.'),
			array(
				'action' => 'update',
				'component' => 'announcement',
				'level' => 1,
				'label' => 'Edit Announcement (Level 1)',
				'help' => 'Update own announcements.'),
			array(
				'action' => 'update',
				'component' => 'announcement',
				'level' => 2,
				'label' => 'Edit Announcement (Level 2)',
				'help' => 'Update any announcement.'),
			array(
				'action' => 'delete',
				'component' => 'announcement',
				'level' => 0,
				'label' => 'Delete Announcement',
				'help' => ''),

			/**
			 * Comment Actions
			 */
			array(
				'action' => 'create',
				'component' => 'comment',
				'level' => 0,
				'label' => 'Create Comment',
				'help' => ''),
			array(
				'action' => 'read',
				'component' => 'comment',
				'level' => 0,
				'label' => 'View All Comments',
				'help' => 'See all non-activated comments.'),
			array(
				'action' => 'update',
				'component' => 'comment',
				'level' => 0,
				'label' => 'Edit Comment',
				'help' => ''),
			array(
				'action' => 'delete',
				'component' => 'comment',
				'level' => 0,
				'label' => 'Delete Comment',
				'help' => ''),

			/**
			 * Report Actions
			 */
			array(
				'action' => 'read',
				'component' => 'report',
				'level' => 1,
				'label' => 'View Reports (Level 1)',
				'help' => 'See the sim stats and milestone reports.'),
			array(
				'action' => 'read',
				'component' => 'report',
				'level' => 2,
				'label' => 'View Reports (Level 2)',
				'help' => 'See the crew activity and posting reports as well as all level 1 reports.'),
			array(
				'action' => 'read',
				'component' => 'report',
				'level' => 3,
				'label' => 'View Reports (Level 3)',
				'help' => 'See the LOA and award nomination reports as well as all level 1 and 2 reports.'),
			array(
				'action' => 'read',
				'component' => 'report',
				'level' => 4,
				'label' => 'View Reports (Level 4)',
				'help' => 'See all system reports.'),

			/**
			 * Ban Actions
			 */
			array(
				'action' => 'create',
				'component' => 'ban',
				'level' => 0,
				'label' => 'Create Ban',
				'help' => ''),
			array(
				'action' => 'read',
				'component' => 'ban',
				'level' => 0,
				'label' => 'View All Bans',
				'help' => ''),
			array(
				'action' => 'update',
				'component' => 'ban',
				'level' => 0,
				'label' => 'Edit Ban',
				'help' => ''),
			array(
				'action' => 'delete',
				'component' => 'ban',
				'level' => 0,
				'label' => 'Delete Ban',
				'help' => ''),

			/**
			 * Position Actions
			 */
			array(
				'action' => 'create',
				'component' => 'position',
				'level' => 0,
				'label' => 'Create Position',
				'help' => ''),
			array(
				'action' => 'read',
				'component' => 'position',
				'level' => 0,
				'label' => 'View All Positions',
				'help' => ''),
			array(
				'action' => 'update',
				'component' => 'position',
				'level' => 0,
				'label' => 'Edit Position',
				'help' => ''),
			array(
				'action' => 'delete',
				'component' => 'position',
				'level' => 0,
				'label' => 'Delete Position',
				'help' => ''),

			/**
			 * Rank Actions
			 */
			array(
				'action' => 'create',
				'component' => 'rank',
				'level' => 0,
				'label' => 'Create Rank',
				'help' => ''),
			array(
				'action' => 'read',
				'component' => 'rank',
				'level' => 0,
				'label' => 'View All Ranks',
				'help' => ''),
			array(
				'action' => 'update',
				'component' => 'rank',
				'level' => 0,
				'label' => 'Edit Rank',
				'help' => ''),
			array(
				'action' => 'delete',
				'component' => 'rank',
				'level' => 0,
				'label' => 'Delete Rank',
				'help' => ''),

			/**
			 * Department Actions
			 */
			array(
				'action' => 'create',
				'component' => 'department',
				'level' => 0,
				'label' => 'Create Department',
				'help' => ''),
			array(
				'action' => 'read',
				'component' => 'department',
				'level' => 0,
				'label' => 'View All Departments',
				'help' => ''),
			array(
				'action' => 'update',
				'component' => 'department',
				'level' => 0,
				'label' => 'Edit Department',
				'help' => ''),
			array(
				'action' => 'delete',
				'component' => 'department',
				'level' => 0,
				'label' => 'Delete Department',
				'help' => ''),

			/**
			 * Catalog Actions
			 */
			array(
				'action' => 'create',
				'component' => 'catalog',
				'level' => 0,
				'label' => 'Create Catalog',
				'help' => ''),
			array(
				'action' => 'read',
				'component' => 'catalog',
				'level' => 0,
				'label' => 'View All Catalogs',
				'help' => ''),
			array(
				'action' => 'update',
				'component' => 'catalog',
				'level' => 0,
				'label' => 'Edit Catalog',
				'help' => ''),
			array(
				'action' => 'delete',
				'component' => 'catalog',
				'level' => 0,
				'label' => 'Delete Catalog',
				'help' => ''),

			/**
			 * Form Actions
			 */
			array(
				'action' => 'read',
				'component' => 'form',
				'level' => 0,
				'label' => 'View All Forms',
				'help' => ''),
			array(
				'action' => 'update',
				'component' => 'form',
				'level' => 0,
				'label' => 'Edit Form',
				'help' => ''),
			array(
				'action' => 'delete',
				'component' => 'form',
				'level' => 0,
				'label' => 'Delete Form',
				'help' => ''),

			/**
			 * Navigation Actions
			 */
			array(
				'action' => 'create',
				'component' => 'nav',
				'level' => 0,
				'label' => 'Create Navigation Item',
				'help' => ''),
			array(
				'action' => 'read',
				'component' => 'nav',
				'level' => 0,
				'label' => 'View All Navigation',
				'help' => ''),
			array(
				'action' => 'update',
				'component' => 'nav',
				'level' => 0,
				'label' => 'Edit Navigation',
				'help' => ''),
			array(
				'action' => 'delete',
				'component' => 'nav',
				'level' => 0,
				'label' => 'Delete Navigation Item',
				'help' => ''),

			/**
			 * Role Actions
			 */
			array(
				'action' => 'create',
				'component' => 'role',
				'level' => 0,
				'label' => 'Create Role',
				'help' => ''),
			array(
				'action' => 'read',
				'component' => 'role',
				'level' => 0,
				'label' => 'View All Roles',
				'help' => ''),
			array(
				'action' => 'update',
				'component' => 'role',
				'level' => 0,
				'label' => 'Edit Role',
				'help' => ''),
			array(
				'action' => 'delete',
				'component' => 'role',
				'level' => 0,
				'label' => 'Delete Role',
				'help' => ''),

			/**
			 * Content Actions
			 */
			array(
				'action' => 'create',
				'component' => 'content',
				'level' => 0,
				'label' => 'Create Content',
				'help' => ''),
			array(
				'action' => 'read',
				'component' => 'content',
				'level' => 0,
				'label' => 'View All Content',
				'help' => ''),
			array(
				'action' => 'update',
				'component' => 'content',
				'level' => 0,
				'label' => 'Edit Content',
				'help' => ''),
			array(
				'action' => 'delete',
				'component' => 'content',
				'level' => 0,
				'label' => 'Delete Content',
				'help' => ''),

			/**
			 * Settings Actions
			 */
			array(
				'action' => 'create',
				'component' => 'settings',
				'level' => 0,
				'label' => 'Create Setting',
				'help' => ''),
			array(
				'action' => 'read',
				'component' => 'settings',
				'level' => 0,
				'label' => 'View All Settings',
				'help' => ''),
			array(
				'action' => 'update',
				'component' => 'settings',
				'level' => 0,
				'label' => 'Edit Setting',
				'help' => ''),
			array(
				'action' => 'delete',
				'component' => 'settings',
				'level' => 0,
				'label' => 'Delete Setting',
				'help' => ''),

			/**
			 * Specs Actions
			 */
			array(
				'action' => 'create',
				'component' => 'specs',
				'level' => 0,
				'label' => 'Create Specification',
				'help' => ''),
			array(
				'action' => 'read',
				'component' => 'specs',
				'level' => 0,
				'label' => 'View All Specifications',
				'help' => ''),
			array(
				'action' => 'update',
				'component' => 'specs',
				'level' => 0,
				'label' => 'Edit Specification',
				'help' => ''),
			array(
				'action' => 'delete',
				'component' => 'specs',
				'level' => 0,
				'label' => 'Delete Specification',
				'help' => ''),

			/**
			 * Tour Actions
			 */
			array(
				'action' => 'create',
				'component' => 'tour',
				'level' => 0,
				'label' => 'Create Tour',
				'help' => ''),
			array(
				'action' => 'read',
				'component' => 'tour',
				'level' => 0,
				'label' => 'View All Tour Items',
				'help' => ''),
			array(
				'action' => 'update',
				'component' => 'tour',
				'level' => 0,
				'label' => 'Edit Tour',
				'help' => ''),
			array(
				'action' => 'delete',
				'component' => 'tour',
				'level' => 0,
				'label' => 'Delete Tour',
				'help' => ''),

			/**
			 * Wiki Actions
			 */
			array(
				'action' => 'create',
				'component' => 'wiki',
				'level' => 1,
				'label' => 'Create Wiki Page',
				'help' => ''),
			array(
				'action' => 'create',
				'component' => 'wiki',
				'level' => 2,
				'label' => 'Create Wiki Categories',
				'help' => ''),
			array(
				'action' => 'update',
				'component' => 'wiki',
				'level' => 1,
				'label' => 'Edit Wiki (Level 1)',
				'help' => 'Update own wiki pages'),
			array(
				'action' => 'update',
				'component' => 'wiki',
				'level' => 2,
				'label' => 'Edit Wiki (Level 2)',
				'help' => 'Update and revert all wiki pages'),
			array(
				'action' => 'update',
				'component' => 'wiki',
				'level' => 3,
				'label' => 'Edit Wiki (Level 3)',
				'help' => 'Update wiki categories'),
			array(
				'action' => 'delete',
				'component' => 'wiki',
				'level' => 1,
				'label' => 'Delete Wiki Page',
				'help' => ''),
			array(
				'action' => 'delete',
				'component' => 'wiki',
				'level' => 2,
				'label' => 'Delete Wiki Categories',
				'help' => ''),

			# TODO: forum actions
		);
		
		foreach ($data as $value)
		{
			DB::table('tasks')->insert($value);
		}
	}
}
