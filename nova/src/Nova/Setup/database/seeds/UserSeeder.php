<?php

class UserSeeder extends Seeder {

	protected $userCount = 25;
	protected $userLoaCount = 50;

	public function run()
	{
		$this->seedUsers();
		$this->seedUserLoas();
	}

	protected function seedUsers()
	{
		$roleStatuses = [
			AccessRoleModel::INACTIVE	=> [Status::INACTIVE],
			AccessRoleModel::USER		=> [Status::PENDING, Status::REMOVED],
			AccessRoleModel::ACTIVE		=> [Status::ACTIVE],
			AccessRoleModel::POWERUSER	=> [Status::ACTIVE],
			AccessRoleModel::ADMIN		=> [Status::ACTIVE],
			AccessRoleModel::SYSADMIN	=> [Status::ACTIVE],
		];

		// Create a new faker instance
		$faker = Faker\Factory::create();

		// Set the total count for the loop
		$total = $this->userCount + 1;

		for ($i=2; $i <= $total; $i++)
		{
			// Get a random role
			$role = array_rand($roleStatuses);

			// Get a random status, but make sure it works with the role
			$status = (count($roleStatuses[$role]) == 1)
				? $roleStatuses[$role][0]
				: $roleStatuses[$role][array_rand($roleStatuses[$role])];

			// Create a new user
			$u = UserModel::create([
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
					$d->value = $faker->paragraph(5);
				}

				if ($d->field->label == 'Interests')
				{
					$d->value = implode(', ', $faker->words(15));
				}
				
				$d->save();
			}
		}
	}

	protected function seedUserLoas()
	{
		// Set the LOA types
		$loaTypes = ['loa', 'eloa'];

		// Set the duration types
		$durations = ['days', 'weeks', 'months'];

		// Create a new faker instance
		$faker = Faker\Factory::create();

		for ($i=1; $i <= $this->userLoaCount; $i++)
		{
			// Set the duration time and type
			$durationTime = $faker->randomDigitNotNull;
			$durationType = $durations[array_rand($durations)];

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
			UserLoaModel::create([
				'user_id'		=> rand(2, ($this->userCount + 1)),
				'start_date'	=> $startDate,
				'end_date'		=> $endDate,
				'duration'		=> "{$durationTime} {$durationType}",
				'reason'		=> $faker->paragraph(),
				'type'			=> $loaTypes[array_rand($loaTypes)],
			]);
		}
	}

}