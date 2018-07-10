<?php

use Nova\Genres\Rank;
use Nova\Genres\Position;
use Nova\Genres\RankInfo;
use Nova\Genres\RankGroup;
use Nova\Genres\Department;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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
				$dept = Department::create($department);

				// Create the positions now
				collect($positions)->each(function ($position) use ($dept) {
					$dept->positions()->create($position);
				});
			});

			// Create the rank groups
			collect($data['rankGroups'])->each(function ($group) {
				RankGroup::create($group);
			});

			// Create the rank info
			collect($data['rankInfo'])->each(function ($i) {
				RankInfo::create($i);
			});

			// Create the ranks
			collect($data['ranks'])->each(function ($rank) {
				Rank::create($rank);
			});
		}
    }
}
