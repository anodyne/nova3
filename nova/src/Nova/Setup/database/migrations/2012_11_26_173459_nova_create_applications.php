<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NovaCreateApplications extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('applications', function(Blueprint $t)
		{
			$t->increments('id');
			$t->integer('user_id')->unsigned();
			$t->integer('character_id')->unsigned();
			$t->integer('position_id')->unsigned();
			$t->boolean('status')->default(Status::PENDING);
			$t->text('sample_post')->nullable();
			$t->timestamps();
		});

		Schema::create('application_responses', function(Blueprint $t)
		{
			$t->bigIncrements('id');
			$t->integer('app_id')->unsigned();
			$t->integer('user_id')->unsigned();
			$t->boolean('type')->default(ApplicationResponseModel::COMMENT);
			$t->text('content')->nullable();
			$t->timestamps();
		});

		Schema::create('application_reviewers', function(Blueprint $t)
		{
			$t->bigIncrements('id');
			$t->integer('app_id')->unsigned();
			$t->integer('user_id')->unsigned();
		});

		Schema::create('application_rules', function(Blueprint $t)
		{
			$t->increments('id');
			$t->string('type', 50)->default('global');
			$t->text('condition')->nullable();
			$t->text('users')->nullable();
		});
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
	
}