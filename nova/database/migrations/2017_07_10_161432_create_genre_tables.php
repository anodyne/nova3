<?php

use Nova\Genres\Rank;
use Nova\Genres\RankInfo;
use Nova\Genres\RankGroup;
use Nova\Genres\Position;
use Nova\Genres\Department;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenreTables extends Migration
{
	public function up()
	{
		Schema::create('departments', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('parent_id')->nullable();
			$table->unsignedInteger('order')->default(99);
			$table->string('name');
			$table->text('description')->nullable();
			$table->unsignedTinyInteger('display')->default((int) true);
			$table->timestamps();
		});

		Schema::create('positions', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('department_id')->nullable();
			$table->unsignedInteger('order')->default(99);
			$table->string('name');
			$table->text('description')->nullable();
			$table->unsignedTinyInteger('available')->default(1);
			$table->unsignedTinyInteger('display')->default((int) true);
			$table->timestamps();

			$table->foreign('department_id')->references('id')->on('departments');
		});

		Schema::create('ranks_groups', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('order')->default(99);
			$table->string('name');
			$table->unsignedTinyInteger('display')->default((int) true);
			$table->timestamps();
		});

		Schema::create('ranks_info', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('order')->default(99);
			$table->string('name');
			$table->string('short_name');
			$table->timestamps();
		});

		Schema::create('ranks', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('order')->default(99);
			$table->unsignedInteger('group_id');
			$table->unsignedInteger('info_id');
			$table->string('base')->nullable();
			$table->string('overlay')->nullable();
			$table->timestamps();

			$table->foreign('group_id')->references('id')->on('ranks_groups');
			$table->foreign('info_id')->references('id')->on('ranks_info');
		});

		$this->seed();
	}

	public function down()
	{
		Schema::dropIfExists('positions');
		Schema::dropIfExists('departments');

		Schema::dropIfExists('ranks');
		Schema::dropIfExists('ranks_info');
		Schema::dropIfExists('ranks_groups');
	}

	protected function seed()
	{
		// Grab the genre
		$genre = config('nova.genre');

		// If this is a blank install, skip seeding altogether
		if ($genre != 'blank') {
			// Pull the data in from the genre file
			$data = include_once database_path("genres/{$genre}.php");

			// Create the departments
			collect($data['departments'])->each(function ($department) {
				$positions = [];

				if (array_key_exists('positions', $department)) {
					// Grab the positions
					$positions = $department['positions'];

					// Get rid of the positions stuff to avoid issues
					unset($department['positions']);
				}
				
				// Create the department
				$dept = factory(Department::class)->create($department);

				// Create the positions now
				collect($positions)->each(function ($position) use ($dept) {
					$dept->positions()->create($position);
				});
			});

			// Create the rank groups
			collect($data['rankGroups'])->each(function ($group) {
				factory(RankGroup::class)->create($group);
			});

			// Create the rank info
			collect($data['rankInfo'])->each(function ($i) {
				factory(RankInfo::class)->create($i);
			});

			// Create the ranks
			collect($data['ranks'])->each(function ($rank) {
				factory(Rank::class)->create($rank);
			});
		}
	}
}
