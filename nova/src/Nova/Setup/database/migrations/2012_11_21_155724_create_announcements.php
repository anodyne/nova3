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
		Schema::create('announcements', function($t)
		{
			$t->increments('id');
			$t->string('title')->default('');
			$t->integer('user_id');
			$t->integer('character_id');
			$t->integer('category_id');
			$t->text('content');
			$t->boolean('status')->default(3);
			$t->boolean('private')->default(0);
			$t->text('tags')->nullable();
			$t->timestamps();
		});

		Schema::create('announcement_categories', function($t)
		{
			$t->increments('id');
			$t->string('name')->default('');
			$t->boolean('status')->default(3);
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
