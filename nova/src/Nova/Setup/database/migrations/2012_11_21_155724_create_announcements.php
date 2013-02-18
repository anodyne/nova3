<?php

use Illuminate\Database\Migrations\Migration;

class CreateAnnouncements extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('announcements', function($table)
		{
			$table->increments('id');
			$table->string('title')->default('');
			$table->integer('user_id');
			$table->integer('character_id');
			$table->integer('category_id');
			$table->text('content');
			$table->boolean('status')->default(3);
			$table->boolean('private')->default(0);
			$table->text('tags')->nullable();
			$table->timestamps();
		});

		Schema::create('announcement_categories', function($table)
		{
			$table->increments('id');
			$table->string('name')->default('');
			$table->boolean('status')->default(3);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('announcements');
		Schema::drop('announcement_categories');
	}

	protected function seed()
	{
		$data = array(
			array('name' => 'General'),
			array('name' => 'Sim'),
			array('name' => 'In-Character'),
			array('name' => 'Out-of-Character'),
			array('name' => 'Website Update'),
		);

		foreach ($data as $value)
		{
			DB::table('announcement_categories')->insert($value);
		}
	}
}
