<?php

use Illuminate\Database\Migrations\Migration;

class NovaCreateRanks extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up($explicitGenre = false)
	{
		// Get the genre
		$genre = ($explicitGenre) ?: Config::get('nova.genre');

		Schema::create("ranks_{$genre}", function($t)
		{
			$t->increments('id');
			$t->integer('info_id')->unsigned();
			$t->integer('group_id')->unsigned();
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

		if ($explicitGenre)
		{
			// Pull in the genre data file
			include SRCPATH."Setup/database/genres/{$genre}.php";

			foreach ($info as $i)
			{
				RankInfoModel::create($i);
			}

			foreach ($groups as $g)
			{
				RankGroupModel::create($g);
			}

			foreach ($ranks as $r)
			{
				RankModel::create($r);
			}
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down($explicitGenre = false)
	{
		// Get the genre
		$genre = ($explicitGenre) ?: Config::get('nova.genre');

		Schema::drop("ranks_{$genre}");
		Schema::drop("ranks_groups_{$genre}");
		Schema::drop("ranks_info_{$genre}");
	}

}