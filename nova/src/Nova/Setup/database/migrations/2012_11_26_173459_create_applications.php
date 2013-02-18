<?php

use Illuminate\Database\Migrations\Migration;

class CreateApplications extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('applications', function($table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('character_id');
			$table->integer('position_id');
			$table->boolean('status')->default(1);
			$table->text('sample_post')->nullable();
			$table->timestamps();
		});

		Schema::create('application_responses', function($table)
		{
			$table->increments('id');
			$table->integer('app_id');
			$table->integer('user_id');
			$table->boolean('type')->default(1);
			$table->text('content')->nullable();
			$table->datetime('created_at');
		});

		Schema::create('application_reviewers', function($table)
		{
			$table->increments('id');
			$table->integer('app_id');
			$table->integer('user_id');
		});

		Schema::create('application_rules', function($table)
		{
			$table->increments('id');
			$table->string('type', 50)->default('global');
			$table->text('condition')->nullable();
			$table->text('users')->nullable();
		});

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
			//\Model_Application_Rule::createItem($r);
		}
	}
}
