<?php

use Illuminate\Database\Migrations\Migration;

class NovaCreateSystem extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('system_info', function($t)
		{
			$t->increments('id');
			$t->string('uid', 32);
			$t->boolean('version_major')->default(3);
			$t->boolean('version_minor');
			$t->boolean('version_update');
			$t->string('ignore', 20)->nullable();
			$t->timestamps();
		});

		Schema::create('system_events', function($t)
		{
			$t->bigIncrements('id');
			$t->string('email', 100)->nullable();
			$t->string('ip', 16);
			$t->integer('user_id')->unsigned()->nullable();
			$t->text('content');
			$t->timestamps();
		});

		Schema::create('system_routes', function($t)
		{
			$t->increments('id');
			$t->string('name');
			$t->string('verb')->default('get');
			$t->string('uri');
			$t->string('resource');
			$t->text('conditions')->nullable();
			$t->boolean('protected')->default(0);
		});

		// Seed the database
		System::create([
			'uid'				=> Str::random(32),
			'version_major'		=> Config::get('nova.app.version_major'),
			'version_minor'		=> Config::get('nova.app.version_minor'),
			'version_update'	=> Config::get('nova.app.version_update'),
		]);

		SystemEventModel::create([
			'ip'		=> Utility::realIp(),
			'content'	=> Config::get('nova.app.name')." was successfully installed.",
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('system_info');
		Schema::drop('system_events');
		Schema::drop('system_routes');
	}
	
}