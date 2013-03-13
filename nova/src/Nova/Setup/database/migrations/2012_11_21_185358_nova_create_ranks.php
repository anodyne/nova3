<?php

use Illuminate\Database\Migrations\Migration;

class NovaCreateRanks extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Get the genre
		$genre = Config::get('nova.genre');

		Schema::create("ranks_{$genre}", function($t)
		{
			$t->increments('id');
			$t->integer('info_id');
			$t->integer('group_id');
			$t->string('base');
			$t->string('pip')->nullable();
			$t->timestamps();
		});

		Schema::create("ranks_groups_{$genre}", function($t)
		{
			$t->increments('id');
			$t->string('name');
			$t->integer('order');
			$t->boolean('status')->default(Status::ACTIVE);
			$t->timestamps();
		});

		Schema::create("ranks_info_{$genre}", function($t)
		{
			$t->increments('id');
			$t->string('name');
			$t->string('short_name')->nullable();
			$t->integer('order');
			$t->integer('group');
			$t->boolean('status')->default(Status::ACTIVE);
			$t->timestamps();
		});

		// Pull in the genre data file
		include SRCPATH."Setup/assets/install/genres/{$genre}.php";

		foreach ($info as $i)
		{
			RankInfoModel::createItem($i);
		}

		foreach ($groups as $g)
		{
			RankGroupModel::createItem($g);
		}

		foreach ($ranks as $r)
		{
			RankModel::createItem($r);
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Get the genre
		$genre = Config::get('nova.genre');

		Schema::drop("ranks_{$genre}");
		Schema::drop("ranks_groups_{$genre}");
		Schema::drop("ranks_info_{$genre}");
	}

}