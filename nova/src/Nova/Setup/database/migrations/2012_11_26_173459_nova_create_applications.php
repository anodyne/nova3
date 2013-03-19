<?php

use Illuminate\Database\Migrations\Migration;

class NovaCreateApplications extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('applications', function($t)
		{
			$t->increments('id');
			$t->integer('user_id');
			$t->integer('character_id');
			$t->integer('position_id');
			$t->boolean('status')->default(Status::PENDING);
			$t->text('sample_post')->nullable();
			$t->timestamps();
		});

		Schema::create('application_responses', function($t)
		{
			$t->increments('id');
			$t->integer('app_id');
			$t->integer('user_id');
			$t->boolean('type')->default(AppResponse::COMMENT);
			$t->text('content')->nullable();
			$t->timestamps();
		});

		Schema::create('application_reviewers', function($t)
		{
			$t->increments('id');
			$t->integer('app_id');
			$t->integer('user_id');
		});

		Schema::create('application_rules', function($t)
		{
			$t->increments('id');
			$t->string('type', 50)->default('global');
			$t->text('condition')->nullable();
			$t->text('users')->nullable();
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
		Schema::drop('applications');
		Schema::drop('application_responses');
		Schema::drop('application_reviewers');
		Schema::drop('application_rules');
	}

	protected function seed()
	{
		$rules = array(
			array(
				'type' => 'global',
				'users' => '{"position":[2]}'),
		);

		foreach ($rules as $r)
		{
			AppRule::createItem($r);
		}
	}
	
}