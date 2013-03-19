<?php

use Illuminate\Database\Migrations\Migration;

class NovaCreateSettings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('settings', function($t)
		{
			$t->increments('id');
			$t->string('key', 100);
			$t->text('value')->nullable();
			$t->string('label')->nullable();
			$t->text('help')->nullable();
			$t->boolean('user_created')->default((int) true);
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
		Schema::drop('settings');
	}

	protected function seed()
	{
		$data = array(
			array(
				'key' => 'sim_name',
				'value' => '',
				'user_created' => (int) false),
			array(
				'key' => 'sim_year',
				'value' => '',
				'user_created' => (int) false),
			array(
				'key' => 'sim_type',
				'value' => 2,
				'user_created' => (int) false),
			array(
				'key' => 'maintenance',
				'value' => 'off',
				'help' => "Maintenance mode allows only admins to log in to the system while updates are being applied or other work is being done",
				'user_created' => (int) false),
			array(
				'key' => 'skin_main',
				'value' => 'default',
				'user_created' => (int) false),
			array(
				'key' => 'skin_admin',
				'value' => 'default',
				'user_created' => (int) false),
			array(
				'key' => 'skin_login',
				'value' => 'default',
				'user_created' => (int) false),
			array(
				'key' => 'rank',
				'value' => 'default',
				'user_created' => (int) false),
			array(
				'key' => 'email_status',
				'value' => Status::ACTIVE,
				'user_created' => (int) false),
			array(
				'key' => 'email_subject',
				'value' => '',
				'help' => "You can set the email subject prefix for every email that comes from the system. The default is your sim name inside brackets.",
				'user_created' => (int) false),
			array(
				'key' => 'email_name',
				'value' => 'Nova',
				'user_created' => (int) false),
			array(
				'key' => 'email_address',
				'value' => 'me@example.com',
				'help' => "To avoid some email services marking emails from Nova as spam, use this email address to set a specific address. This defaults to an address that should prevent this issue.",
				'user_created' => (int) false),
			array(
				'key' => 'email_protocol',
				'value' => 'mail',
				'user_created' => (int) false),
			array(
				'key' => 'email_smtp_server',
				'value' => 'smtp.example.com',
				'user_created' => (int) false),
			array(
				'key' => 'email_smtp_port',
				'value' => 25,
				'user_created' => (int) false),
			array(
				'key' => 'email_smtp_encryption',
				'value' => '',
				'help' => "Nova supports sending SMTP emails over SSL or TLS. If you aren't using encryption, leave this blank.",
				'user_created' => (int) false),
			array(
				'key' => 'email_smtp_username',
				'value' => 'username',
				'user_created' => (int) false),
			array(
				'key' => 'email_smtp_password',
				'value' => 'password',
				'user_created' => (int) false),
			array(
				'key' => 'email_sendmail_path',
				'value' => '/usr/sbin/sendmail -bs',
				'user_created' => (int) false),
			array(
				'key' => 'timezone',
				'value' => 'UTC',
				'user_created' => (int) false),
			array(
				'key' => 'date_format',
				'value' => '%d %B %Y',
				'user_created' => (int) false),
			array(
				'key' => 'updates',
				'value' => '4',
				'user_created' => (int) false),
			array(
				'key' => 'post_count_format',
				'value' => 'multiple',
				'help' => "Posts can be counted in two ways: one post no matter how many authors (single) or a post for each author (multiple)",
				'user_created' => (int) false),
			array(
				'key' => 'use_mission_notes',
				'value' => 'y',
				'user_created' => (int) false),
			array(
				'key' => 'online_timespan',
				'value' => '5',
				'help' => "This is used for the Who's Online feature and should be set in minutes. The higher the number, the less accurate the data, but the lower impact it'll have on the server.",
				'user_created' => (int) false),
			array(
				'key' => 'posting_requirement',
				'value' => 14,
				'help' => "The timespan (in days) that a player must post within. Set this to 0 to remove the requirement.",
				'user_created' => (int) false),
			array(
				'key' => 'login_attempts',
				'value' => 5,
				'help' => "The number of times a user can attempt to log in before being locked out. This feature exists to help protect sites against brute-force attacks.",
				'user_created' => (int) false),
			array(
				'key' => 'login_lockout_time',
				'value' => 15,
				'help' => "When a user is locked out because of too many log in attempts, this is the number of minutes they need to wait before logging in again. This goes hand-in-hand with the lockout system to protect against brute-force atatcks.",
				'user_created' => (int) false),
			array(
				'key' => 'meta_description',
				'value' => "Anodyne Productions' premier online RPG management software",
				'user_created' => (int) false),
			array(
				'key' => 'meta_keywords',
				'value' => "nova, rpg management, anodyne, rpg, sms",
				'user_created' => (int) false),
			array(
				'key' => 'meta_author',
				'value' => "Anodyne Productions",
				'user_created' => (int) false),
		);

		// Loop through and insert the data
		foreach ($data as $d)
		{
			Settings::add($d);
		}
	}

}