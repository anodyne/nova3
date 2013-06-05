<?php

class UserSeeder extends Seeder {

	public function run()
	{
		$userNames = ['Bennie Duran', 'Jeffery Holmes', 'Billy Williams', 'Tara Carver', 'Evengelina Lisle', 'Lea Johnson', 'Jeffrie Riojas', 'Vivian Valletta', 'Felicia Burnette', 'Nola Thorne', 'Kevin Waters', 'Phyllis Franklin', 'Sheri Starr', 'Richard Hayden', 'Gregory Wheat', 'Gerard Balmer', 'George Motley', 'Raymond Fraga', 'James Kohler', 'Donald Murray', 'Rick Olive', 'Susan Stanton', 'Julie Miller', 'Frank Morales', 'Ruby Stefanski', 'April Rogers', 'Tyrone Anderson', 'James Ali', 'Michael Davila', 'Donna Boyett', 'Rosemary Payne', 'Joyce Overcash', 'Arnold Wagnon', 'Andrew Frazier', 'Ana Lamb', 'Earl Nebel', 'Ronald Wright', 'Clarissa Worth', 'Bennie Rittenhouse', 'Mildred Dumas', 'Burl Terry', 'Mollie Williams', 'Brenda Sanchez', 'Frances Erby', 'Beverly Meeker', 'Bobbye Millard', 'Orlando Riggs', 'Lori Best', 'Kristin Ferguson', 'Phyllis Morales'];

		$roleStatuses = [
			AccessRole::INACTIVE	=> [Status::INACTIVE],
			AccessRole::USER		=> [Status::PENDING, Status::REMOVED],
			AccessRole::ACTIVE		=> [Status::ACTIVE],
			AccessRole::POWERUSER	=> [Status::ACTIVE],
			AccessRole::ADMIN		=> [Status::ACTIVE],
			AccessRole::SYSADMIN	=> [Status::ACTIVE],
		];

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
		}
	}

}