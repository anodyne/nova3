<?php

use Illuminate\Database\Migrations\Migration;

class CreateAwards extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('awards', function($table)
		{
			$table->increments('id');
			$table->string('name')->nullable();
			$table->string('image', 100)->nullable();
			$table->integer('category_id')->nullable();
			$table->integer('order')->nullable();
			$table->text('desc')->nullable();
			$table->string('type')->default('ic');
			$table->boolean('status')->default(3);
		});

		Schema::create('award_categories', function($table)
		{
			$table->increments('id');
			$table->string('name')->nullable();
			$table->text('desc')->nullable();
			$table->boolean('status')->default(3);
		});

		Schema::create('award_queue', function($table)
		{
			$table->increments('id');
			$table->integer('receiver_user_id');
			$table->integer('sender_user_id');
			$table->integer('award_id');
			$table->text('reason')->nullable();
			$table->boolean('status')->default(3);
			$table->datetime('created_at');
		});

		Schema::create('award_received', function($table)
		{
			$table->increments('id');
			$table->integer('receiver_user_id');
			$table->integer('sender_user_id');
			$table->integer('award_id');
			$table->text('reason')->nullable();
			$table->datetime('created_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('awards');
		Schema::drop('award_categories');
		Schema::drop('award_queue');
		Schema::drop('award_received');
	}
}
