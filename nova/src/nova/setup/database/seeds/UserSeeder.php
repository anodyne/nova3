<?php

class UserSeeder extends Seeder {

	public function run()
	{
		$this->seedUsers();
		$this->seedUserLoas();
	}

	protected function seedUsers()
	{
		$roleStatuses = [
			AccessRole::INACTIVE	=> [Status::INACTIVE],
			AccessRole::USER		=> [Status::PENDING, Status::REMOVED],
			AccessRole::ACTIVE		=> [Status::ACTIVE],
			AccessRole::POWERUSER	=> [Status::ACTIVE],
			AccessRole::ADMIN		=> [Status::ACTIVE],
			AccessRole::SYSADMIN	=> [Status::ACTIVE],
		];

		// Create a new faker instance
		$faker = Faker\Factory::create();

		for ($i=2; $i<=26; $i++)
		{
			// Get a random role
			$role = array_rand($roleStatuses);

			// Get a random status, but make sure it works with the role
			$status = (count($roleStatuses[$role]) == 1)
				? $roleStatuses[$role][0]
				: $roleStatuses[$role][array_rand($roleStatuses[$role])];

			// Get a random user name
			$userKey = array_rand($userNames);

			// Get the user name
			$userName = $userNames[$userKey];

			// Create a new user
			$u = User::create([
				'name'			=> $faker->firstName.' '.$faker->lastName,
				'email'			=> $faker->safeEmail,
				'character_id'	=> $i,
				'role_id'		=> $role,
				'status'		=> $status,
				'password'		=> "password",
			]);

			// Loop through the data items and put dummy data in
			foreach ($u->data as $d)
			{
				if ($d->field->label == 'Location')
				{
					$d->value = $faker->country;
				}

				if ($d->field->label == 'Bio')
				{
					$d->value = $faker->paragraph();
				}

				if ($d->field->label == 'Interests')
				{
					$d->value = $faker->sentence();
				}
				
				$d->save();
			}
		}

		/*$userNames = ['Bennie Duran', 'Jeffery Holmes', 'Billy Williams', 'Tara Carver', 'Evengelina Lisle', 'Lea Johnson', 'Jeffrie Riojas', 'Vivian Valletta', 'Felicia Burnette', 'Nola Thorne', 'Kevin Waters', 'Phyllis Franklin', 'Sheri Starr', 'Richard Hayden', 'Gregory Wheat', 'Gerard Balmer', 'George Motley', 'Raymond Fraga', 'James Kohler', 'Donald Murray', 'Rick Olive', 'Susan Stanton', 'Julie Miller', 'Frank Morales', 'Ruby Stefanski', 'April Rogers', 'Tyrone Anderson', 'James Ali', 'Michael Davila', 'Donna Boyett', 'Rosemary Payne', 'Joyce Overcash', 'Arnold Wagnon', 'Andrew Frazier', 'Ana Lamb', 'Earl Nebel', 'Ronald Wright', 'Clarissa Worth', 'Bennie Rittenhouse', 'Mildred Dumas', 'Burl Terry', 'Mollie Williams', 'Brenda Sanchez', 'Frances Erby', 'Beverly Meeker', 'Bobbye Millard', 'Orlando Riggs', 'Lori Best', 'Kristin Ferguson', 'Phyllis Morales'];

		

		$usersToUse = array_rand($userNames, 25);

		// Run the loop and create 25 users
		for ($i=2; $i <= 26; $i++)
		{
			// Get a random role
			$role = array_rand($roleStatuses);

			// Get a random status, but make sure it works with the role
			$status = (count($roleStatuses[$role]) == 1)
				? $roleStatuses[$role][0]
				: $roleStatuses[$role][array_rand($roleStatuses[$role])];

			// Get a random user name
			$userKey = array_rand($userNames);

			// Get the user name
			$userName = $userNames[$userKey];

			// Create a new user
			$u = User::create([
				'name'			=> $userName,
				'email'			=> strtolower(str_replace(' ', '.', $userName)).'@example.com',
				'character_id'	=> $i,
				'role_id'		=> $role,
				'status'		=> $status,
				'password'		=> "password",
			]);

			// Loop through the data items and put dummy data in
			foreach ($u->data as $d)
			{
				if ($d->field->label == 'Location')
				{
					$d->value = "Somewhere, Earth";
				}

				if ($d->field->label == 'Bio')
				{
					$d->value = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut at risus est. Duis eget turpis a nunc dictum bibendum vitae in dui. Duis accumsan dolor id lorem lobortis a pulvinar dolor interdum. Aliquam adipiscing velit sed lorem malesuada auctor. Aenean ultricies sodales egestas. Vivamus mollis diam sed mi convallis luctus. Nulla non feugiat magna. Curabitur tincidunt malesuada metus bibendum suscipit.";
				}

				if ($d->field->label == 'Interests')
				{
					$d->value = "Lorem, ipsum, dolor, sit, amet, consectetur, adipiscing, elit";
				}
				
				$d->save();
			}

			// Remove the used name
			unset($userNames[$userKey]);
		}*/
	}

	protected function seedUserLoas()
	{
		// Set the LOA types
		$loaTypes = ['loa', 'eloa'];

		// Set the duration types
		$durations = ['days', 'weeks', 'months'];

		// Create a new faker instance
		$faker = Faker\Factory::create();

		for ($i=1; $i <=50; $i++)
		{
			// Set the duration time and type
			$durationTime = $faker->randomDigitNotNull;
			$durationType = $durations[array_rand()];

			// Create a start date
			$startDate = Date::createFromTimestampUTC($faker->unixTime);

			// Figure out how much time we need to add
			switch ($durationType)
			{
				case 'days':
					$endDate = $startDate->copy()->addDays($durationTime);
				break;

				case 'weeks':
					$endDate = $startDate->copy()->addWeeks($durationTime);
				break;

				case 'months':
					$endDate = $startDate->copy()->addMonths($durationTime);
				break;
			}

			// Create the LOA records
			UserLoa::create([
				'user_id'		=> rand(2, 26),
				'start_date'	=> $startDate,
				'end_date'		=> $endDate,
				'duration'		=> "{$durationTime} {$durationType}",
				'reason'		=> $faker->paragraph(),
				'type'			=> $loaTypes[array_rand()],
			]);
		}

		/*$loas = [
			[
				'user_id'		=> 2,
				'start_date'	=> Date::createFromDate(2010, 04, 10, 'UTC'),
				'end_date'		=> Date::createFromDate(2010, 04, 10, 'UTC')->addDays(6),
				'duration'		=> '5 days',
				'reason'		=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut at risus est. Duis eget turpis a nunc dictum bibendum vitae in dui.',
				'type'			=> 'loa',
			],
			[
				'user_id'		=> 3,
				'start_date'	=> Date::createFromDate(2010, 08, 22, 'UTC'),
				'duration'		=> '2 weeks',
				'reason'		=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut at risus est. Duis eget turpis a nunc dictum bibendum vitae in dui.',
				'type'			=> 'loa',
			],
			[
				'user_id'		=> 4,
				'start_date'	=> Date::createFromDate(2010, 12, 02, 'UTC'),
				'end_date'		=> Date::createFromDate(2010, 12, 02, 'UTC')->addMonths(2),
				'duration'		=> '2 months',
				'reason'		=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut at risus est. Duis eget turpis a nunc dictum bibendum vitae in dui.',
				'type'			=> 'eloa',
			],
			[
				'user_id'		=> 5,
				'start_date'	=> Date::createFromDate(2011, 02, 05, 'UTC'),
				'duration'		=> '6 months',
				'reason'		=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut at risus est. Duis eget turpis a nunc dictum bibendum vitae in dui.',
				'type'			=> 'eloa',
			],
			[
				'user_id'		=> 9,
				'start_date'	=> Date::createFromDate(2011, 05, 01, 'UTC'),
				'duration'		=> '10 days',
				'reason'		=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut at risus est. Duis eget turpis a nunc dictum bibendum vitae in dui.',
				'type'			=> 'loa',
			],
			[
				'user_id'		=> 14,
				'start_date'	=> Date::createFromDate(2011, 07, 02, 'UTC'),
				'end_date'		=> Date::createFromDate(2011, 07, 02, 'UTC')->addDays(6),
				'duration'		=> 'A week',
				'reason'		=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut at risus est. Duis eget turpis a nunc dictum bibendum vitae in dui.',
				'type'			=> 'loa',
			],
		];

		foreach ($loas as $loa)
		{
			UserLoa::create($loa);
		}*/
	}

}