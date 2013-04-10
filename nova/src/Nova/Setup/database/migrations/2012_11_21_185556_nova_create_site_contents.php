<?php

use Illuminate\Database\Migrations\Migration;

class NovaCreateSiteContents extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('site_contents', function($t)
		{
			$t->increments('id');
			$t->string('key')->unique();
			$t->string('label')->nullable();
			$t->text('content')->nullable();
			$t->string('type');
			$t->string('section', 50)->nullable();
			$t->string('page', 100)->nullable();
			$t->boolean('protected')->default((int) false);
		});

		// Seed the database
		$this->seed();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('site_contents');
	}

	protected function seed()
	{
		$data = array(
			/**
			 * Headers
			 */
			array(
				'key' => 'login_index_header',
				'label' => 'Login Header',
				'content' => "Log In",
				'type' => 'header',
				'section' => 'login',
				'page' => 'index'),
			array(
				'key' => 'login_reset_header',
				'label' => 'Reset Password Header',
				'content' => "Reset Password",
				'type' => 'header',
				'section' => 'login',
				'page' => 'reset'),
			array(
				'key' => 'login_reset_confirm_header',
				'label' => 'Confirm Reset Password Header',
				'content' => "Confirm Password Reset",
				'type' => 'header',
				'section' => 'login',
				'page' => 'reset_confirm'),
			array(
				'key' => 'login_logout_header',
				'label' => 'Logout Header',
				'content' => "Logout",
				'type' => 'header',
				'section' => 'login',
				'page' => 'logout'),
			array(
				'key' => 'main_index_header',
				'label' => 'Main Page Header',
				'content' => "Welcome to Nova!",
				'type' => 'header',
				'section' => 'main',
				'page' => 'index'),
			array(
				'key' => 'main_credits_header',
				'label' => 'Site Credits Header',
				'content' => 'Site Credits',
				'type' => 'header',
				'section' => 'main',
				'page' => 'credits'),
			array(
				'key' => 'main_join_header',
				'label' => 'Join Header',
				'content' => 'Join',
				'type' => 'header',
				'section' => 'main',
				'page' => 'join'),
			array(
				'key' => 'sim_index_header',
				'label' => 'Sim Header',
				'content' => "The Sim",
				'type' => 'header',
				'section' => 'sim',
				'page' => 'index'),
			array(
				'key' => 'admin_index_header',
				'label' => 'ACP Header',
				'content' => "Control Panel",
				'type' => 'header',
				'section' => 'admin',
				'page' => 'index'),
			array(
				'key' => 'admin_form_index_header',
				'label' => 'Form Management Header',
				'content' => "Forms",
				'type' => 'header',
				'section' => 'form',
				'page' => 'index'),
			array(
				'key' => 'admin_form_fields_header',
				'label' => 'Form Field Management Header',
				'content' => "Manage Form Fields",
				'type' => 'header',
				'section' => 'form',
				'page' => 'fields'),
			array(
				'key' => 'admin_form_sections_header',
				'label' => 'Form Section Management Header',
				'content' => "Manage Form Sections",
				'type' => 'header',
				'section' => 'form',
				'page' => 'sections'),
			array(
				'key' => 'admin_form_tabs_header',
				'label' => 'Form Tab Management Header',
				'content' => "Manage Form Tabs",
				'type' => 'header',
				'section' => 'form',
				'page' => 'tabs'),
			array(
				'key' => 'admin_ranks_index_header',
				'label' => 'Ranks Index Header',
				'content' => "Ranks",
				'type' => 'header',
				'section' => 'rank',
				'page' => 'index'),
			array(
				'key' => 'admin_ranks_groups_header',
				'label' => 'Rank Groups Management Header',
				'content' => "Rank Groups",
				'type' => 'header',
				'section' => 'rank',
				'page' => 'groups'),
			array(
				'key' => 'admin_ranks_info_header',
				'label' => 'Rank Info Management Header',
				'content' => "Rank Info",
				'type' => 'header',
				'section' => 'rank',
				'page' => 'info'),
			array(
				'key' => 'admin_ranks_manage_header',
				'label' => 'Rank Management Header',
				'content' => "Ranks",
				'type' => 'header',
				'section' => 'rank',
				'page' => 'manage'),
			array(
				'key' => 'admin_arc_index_header',
				'label' => 'ARC Index Header',
				'content' => "Application Review Center",
				'type' => 'header',
				'section' => 'application',
				'page' => 'index'),
			array(
				'key' => 'admin_arc_rules_header',
				'label' => 'ARC Rules Header',
				'content' => "Application Review Rules",
				'type' => 'header',
				'section' => 'application',
				'page' => 'rules'),
			array(
				'key' => 'admin_arc_history_header',
				'label' => 'ARC History Header',
				'content' => "Application History",
				'type' => 'header',
				'section' => 'application',
				'page' => 'history'),
			array(
				'key' => 'admin_arc_review_header',
				'label' => 'ARC Review Header',
				'content' => "Application Review",
				'type' => 'header',
				'section' => 'application',
				'page' => 'review'),
			array(
				'key' => 'admin_user_management_header',
				'label' => 'User Management Header',
				'content' => "Users",
				'type' => 'header',
				'section' => 'user',
				'page' => 'index'),

			/**
			 * Page Titles
			 */
			array(
				'key' => 'login_index_title',
				'label' => 'Login Page Title',
				'content' => "Log In",
				'type' => 'title',
				'section' => 'login',
				'page' => 'index'),
			array(
				'key' => 'login_reset_title',
				'label' => 'Reset Password Page Title',
				'content' => "Reset Password",
				'type' => 'title',
				'section' => 'login',
				'page' => 'reset'),
			array(
				'key' => 'login_reset_confirm_title',
				'label' => 'Confirm Reset Password Page Title',
				'content' => "Confirm Password Reset",
				'type' => 'title',
				'section' => 'login',
				'page' => 'reset_confirm'),
			array(
				'key' => 'login_logout_title',
				'label' => 'Logout Page Title',
				'content' => "Logout",
				'type' => 'title',
				'section' => 'login',
				'page' => 'logout'),
			array(
				'key' => 'main_index_title',
				'label' => 'Main Page Title',
				'content' => "Welcome to Nova!",
				'type' => 'title',
				'section' => 'main',
				'page' => 'index'),
			array(
				'key' => 'main_credits_title',
				'label' => 'Site Credits Page Title',
				'content' => 'Site Credits',
				'type' => 'title',
				'section' => 'main',
				'page' => 'credits'),
			array(
				'key' => 'main_join_title',
				'label' => 'Join Page Title',
				'content' => 'Join',
				'type' => 'title',
				'section' => 'main',
				'page' => 'join'),
			array(
				'key' => 'sim_index_title',
				'label' => 'Sim Page Title',
				'content' => "The Sim",
				'type' => 'title',
				'section' => 'sim',
				'page' => 'index'),
			array(
				'key' => 'admin_index_title',
				'label' => 'ACP Page Title',
				'content' => "Control Panel",
				'type' => 'title',
				'section' => 'admin',
				'page' => 'index'),
			array(
				'key' => 'admin_form_index_title',
				'label' => 'Form Management Page Title',
				'content' => "Forms",
				'type' => 'title',
				'section' => 'form',
				'page' => 'index'),
			array(
				'key' => 'admin_form_fields_title',
				'label' => 'Form Field Management Page Title',
				'content' => "Manage Form Fields",
				'type' => 'title',
				'section' => 'form',
				'page' => 'fields'),
			array(
				'key' => 'admin_form_sections_title',
				'label' => 'Form Section Management Page Title',
				'content' => "Manage Form Sections",
				'type' => 'title',
				'section' => 'form',
				'page' => 'sections'),
			array(
				'key' => 'admin_form_tabs_title',
				'label' => 'Form Tab Management Page Title',
				'content' => "Manage Form Tabs",
				'type' => 'title',
				'section' => 'form',
				'page' => 'tabs'),
			array(
				'key' => 'admin_ranks_index_title',
				'label' => 'Ranks Index Page Title',
				'content' => "Ranks",
				'type' => 'title',
				'section' => 'rank',
				'page' => 'index'),
			array(
				'key' => 'admin_ranks_groups_title',
				'label' => 'Rank Groups Management Page Title',
				'content' => "Rank Groups",
				'type' => 'title',
				'section' => 'rank',
				'page' => 'groups'),
			array(
				'key' => 'admin_ranks_info_title',
				'label' => 'Rank Info Management Page Title',
				'content' => "Rank Info",
				'type' => 'title',
				'section' => 'rank',
				'page' => 'info'),
			array(
				'key' => 'admin_ranks_manage_title',
				'label' => 'Rank Management Page Title',
				'content' => "Ranks",
				'type' => 'title',
				'section' => 'rank',
				'page' => 'manage'),
			array(
				'key' => 'admin_arc_index_title',
				'label' => 'ARC Index Page Title',
				'content' => "Application Review Center",
				'type' => 'title',
				'section' => 'application',
				'page' => 'index'),
			array(
				'key' => 'admin_arc_rules_title',
				'label' => 'ARC Rules Page Title',
				'content' => "Application Review Rules",
				'type' => 'title',
				'section' => 'application',
				'page' => 'rules'),
			array(
				'key' => 'admin_arc_history_title',
				'label' => 'ARC History Page Title',
				'content' => "Application History",
				'type' => 'title',
				'section' => 'application',
				'page' => 'history'),
			array(
				'key' => 'admin_arc_review_title',
				'label' => 'ARC Review Page Title',
				'content' => "Application Review",
				'type' => 'title',
				'section' => 'application',
				'page' => 'review'),
			array(
				'key' => 'admin_user_management_title',
				'label' => 'User Management Page Title',
				'content' => "Users",
				'type' => 'title',
				'section' => 'user',
				'page' => 'index'),

			/**
			 * Messages
			 */
			array(
				'key' => 'login_reset_message',
				'label' => 'Reset Password Message',
				'content' => "To reset your password, simply enter your email address. You'll receive an email shortly with a link to confirm your password reset. If you log in to the site before confirming your password reset, the reset will be cancelled.",
				'type' => 'message',
				'section' => 'login',
				'page' => 'reset',
				'protected' => (int) true),
			array(
				'key' => 'login_reset_confirm_message',
				'label' => 'Confirm Reset Password Message',
				'content' => "The second step of the password reset process is confirmation. In order to complete your password reset, enter a new password and click the button below and your password will be changed. If you did not request a password reset, you can simply log in to the site to cancel the reset request.",
				'type' => 'message',
				'section' => 'login',
				'page' => 'reset_confirm',
				'protected' => (int) true),
			array(
				'key' => 'main_index_message',
				'label' => 'Main Page Message',
				'content' => "Define your welcome message and welcome page header through the Site Content page.",
				'type' => 'message',
				'section' => 'main',
				'page' => 'index'),
			array(
				'key' => 'main_credits_message',
				'label' => 'Credits',
				'content' => "Define your site credits through the Site Messages page.",
				'type' => 'message',
				'section' => 'main',
				'page' => 'credits'),
			array(
				'key' => 'main_join_message',
				'label' => 'Join Message',
				'content' => "Define your join message through the Site Messages page.",
				'type' => 'message',
				'section' => '',
				'page' => ''),
			array(
				'key' => 'main_join_coppa_message',
				'label' => 'COPPA Message',
				'content' => "Members are expected to follow the rules and regulations of both the game and game's organization at all times, both in character and out of character. By continuing, you affirm you will play in a proper and adequate manner. In compliance with the Children's Online Privacy Protection Act of 1998 (COPPA), players under the age of 13 will not be accepted and any player found to be under the age of 13 will be removed immediately and without question.",
				'type' => 'message',
				'section' => '',
				'page' => ''),
			array(
				'key' => 'sim_index_message',
				'label' => 'Sim Message',
				'content' => "Define your sim message through the Site Content page.",
				'type' => 'message',
				'section' => 'sim',
				'page' => 'index'),
			array(
				'key' => 'admin_index_message',
				'label' => 'ACP Message',
				'content' => "Define your admin control panel through the Site Content page.",
				'type' => 'message',
				'section' => 'admin',
				'page' => 'index'),
			array(
				'key' => 'admin_ranks_groups_message',
				'label' => 'Manage Rank Groups Message',
				'content' => "Rank groups are a simple way to organize ranks into logical groupings. Every rank in the system belongs to a rank group, allowing admins to easily add new groups of ranks. Nova comes with several rank groups already, but you can easily create new groups and add ranks to them from rank management.",
				'type' => 'message',
				'section' => 'rank',
				'page' => 'groups'),
			array(
				'key' => 'admin_ranks_info_message',
				'label' => 'Manage Rank Info Message',
				'content' => "Rank info contains all of the basic information about ranks that's repeated across multiple ranks, like name, short name, and order. Every rank in the system references one of the rank info records below, meaning that several ranks can be updated simultaneously by changing one of the info records. You can easily create new info records and use them with ranks or edit existing items.",
				'type' => 'message',
				'section' => 'rank',
				'page' => 'info'),
			array(
				'key' => 'admin_ranks_manage_message',
				'label' => 'Manage Ranks Message',
				'content' => "Ranks are made up of several different componets to keep things as flexible as possible. The ranks records below are composed of a rank info, a rank group, a base image, and a pip image. From here, you can change any and all of those pieces to customize your ranks to your liking.",
				'type' => 'message',
				'section' => 'rank',
				'page' => 'manage'),
			array(
				'key' => 'admin_arc_index_message',
				'label' => 'ARC Index Message',
				'content' => "",
				'type' => 'message',
				'section' => 'application',
				'page' => 'index'),
			array(
				'key' => 'admin_arc_rules_message',
				'label' => 'ARC Rules Message',
				'content' => "Application review rules are a way to automatically add specific users or users who hold specific positions to a review when an application is received. You can create as many rules as you want that will be evaluated and run on every new application. Rules whose conditions cannot be met will be ignored.",
				'type' => 'message',
				'section' => 'application',
				'page' => 'rules'),

			/**
			 * Other Messages
			 */
			array(
				'key' => 'credits_perm',
				'label' => 'Permanent Credits',
				'content' => "The Nova 3 experience can be summed up as \"smarter and better\". From the top down, Nova is faster, simpler, more flexible, and smarter than before. This is accomplished in no small part by the simple, flexible, and elegant PHP 5.3 foundation of <a href='http://fuelphp.com/' target='_blank'>FuelPHP</a>. The icons found throughout Nova are the tireless work of <a href='http://p.yusukekamiyamane.com/' target='_blank'>Yusuke Kamiyamane</a> (Fugue), <a href='http://pictos.cc' target='_blank'>Drew Wilson</a> (Pictos), and <a href='http://glyphicons.com/' target='_blank'>Jan Kovařík</a> (Glyphicons).",
				'protected' => (int) true,
				'type' => 'other'),
			array(
				'key' => 'footer',
				'label' => 'Additional Footer Information',
				'content' => "New to Nova 3 is the ability to add additional information to the footer, like banner exchanges, without having to edit any files. Just plug your code/message into the 'Additional Footer Information' site content item!",
				'type' => 'other'),
			array(
				'key' => 'join_disclaimer',
				'label' => 'Join Disclaimer',
				'content' => "Members are expected to follow the rules and regulations of both the sim and fleet at all times, both in character and out of character. By continuing, you affirm that you will sim in a proper and adequate manner. Members who choose to make ultra short posts, post very infrequently, or post posts with explicit content (above PG-13) will be removed immediately, and by continuing, you agree to this. In addition, in compliance with the Children's Online Privacy Protection Act of 1998 (COPPA), we do not accept players under the age of 13.  Any players found to be under the age of 13 will be immediately removed without question.  By agreeing to these terms, you are also saying that you are above the age of 13.",
				'type' => 'other'),
			array(
				'key' => 'join_sample_post',
				'label' => 'Join Sample Post',
				'content' => "Define your join sample post through the Site Content page. If you don't want to use a sample post, simply leave this blank.",
				'type' => 'other'),
			array(
				'key' => 'accept_message',
				'label' => 'User Acceptance Email',
				'content' => "Define your user acceptance message through the Site Content page.",
				'type' => 'other'),
			array(
				'key' => 'reject_message',
				'label' => 'User Rejection Message',
				'content' => "Define your user rejection message through the Site Content page.",
				'type' => 'other'),
			array(
				'key' => 'join_character_help',
				'label' => 'Join Character Help',
				'content' => "__Tips for a good character application:__

* Be unique. No one likes interacting with a character that can do everything perfectly. Look for ways to make your character fresh and exciting and to give them shortcomings and weaknesses.
* A character isn't his/her position, but a person with a job. Before they work here, they started somewhere. In this sense, their past has defined their arrival to this place and defined who they are. What brought the character here? There should be a logical reason the character is in the here-and-now of the game situation.
* A character fits into the world in a specific way. They were born somewhere and are a product of their time (war, poverty, disease, prosperity, etc.). Use those factors to craft a narrative about the character.
* Many people choose to use exaggerated aspects of their own personality (as well as a complimentary weakness). Doing so will make it easier to write the character because you know how you would react in given situations.",
		'type' => 'other'),
		);

		// Loop through the insert the data
		foreach ($data as $d)
		{
			SiteContent::add($d);
		}
	}

}