<?php

use Faker;
use Illuminate\Database\Seeder;

class FormSeeder extends Seeder {
	
	public function run()
	{
		$faker = Faker\Factory::create();

		$forms = ['mission-ideas'];

		$data = [
			'mission-ideas' => [
				'form' => [
					'key' => 'mission-ideas',
					'name' => "Mission Ideas",
					'orientation' => $faker->randomElement(['vertical', 'horizontal']),
					'use_form_center' (int) true,
					'message' => $faker->paragraph(5)
				],

				'tabs' => [],

				'sections' => [],

				'fields' => [],

				'entries' => [],

				'data' => [],
			],
		];

		// Build up the repos
		$formRepo = app('FormRepository');
		$tabRepo = app('FormTabRepository');
		$sectionRepo = app('FormSectionRepository');
		$fieldRepo = app('FormFieldRepository');

		// Create the forms
		foreach ($forms as $form)
		{
			$formRepo->create($data[$form]['form']);

			// Create any tabs
			foreach ($data[$form]['tabs'] as $tab)
			{
				$tabRepo->create($tab);
			}
		}

		// Create any tabs

		// Create any sections

		// Create any fields
	}
	
}
