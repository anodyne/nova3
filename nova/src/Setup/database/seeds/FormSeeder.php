<?php

use Illuminate\Database\Seeder;

class FormSeeder extends Seeder
{
	public function run()
	{
		$faker = \Faker\Factory::create();

		// Build up the repos
		$formRepo = app('FormRepository');
		$fieldRepo = app('FormFieldRepository');
		$entryRepo = app('FormEntryRepository');
		$dataRepo = app('FormDataRepository');

		$fields = [];

		$restrictions = [
			['type' => 'view', 'value' => ''],
			['type' => 'add', 'value' => ''],
			['type' => 'edit', 'value' => ''],
			['type' => 'remove', 'value' => ''],
		];

		// Create a test form
		$form = $formRepo->create([
			'key' => 'mission-ideas',
			'name' => "Mission Ideas",
			'orientation' => $faker->randomElement(['vertical', 'horizontal']),
			'use_form_center' => (int) true,
			'message' => $faker->paragraph(5),
			'allow_multiple_submissions' => (int) true,
			'restrictions' => json_encode($restrictions),
		]);

		// Create some fields
		$fields[] = $fieldRepo->create([
			'form_id' => $form->id,
			'type' => 'text-field',
			'order' => 0,
			'label' => "Title",
			'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":""}]',
			'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]',
		]);

		$fields[] = $fieldRepo->create([
			'form_id' => $form->id,
			'type' => 'text-block',
			'order' => 1,
			'label' => "Summary",
			'field_container_class' => "col-md-8",
			'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":""},{"name":"rows","value":"3"}]',
			'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]',
		]);

		$fields[] = $fieldRepo->create([
			'form_id' => $form->id,
			'type' => 'text-block',
			'order' => 2,
			'label' => "Notes",
			'field_container_class' => "col-md-8",
			'attributes' => '[{"name":"class","value":"form-control input-lg"},{"name":"placeholder","value":""},{"name":"rows","value":"8"}]',
			'restrictions' => '[{"type":"view","value":""},{"type":"create","value":""},{"type":"edit","value":""}]',
		]);

		$form->entry_identifier = $fields[0]->id;
		$form->save();

		// Create some entries
		for ($i = 1; $i <= 50; $i++) {
			$userId = $faker->numberBetween(1, 11);

			$entry = $entryRepo->create([
				'form_id' => $form->id,
				'user_id' => $userId,
			]);

			foreach ($fields as $field) {
				$value = ($field->type == 'text')
					? ucwords($faker->words($faker->numberBetween(3, 8), true))
					: $faker->paragraphs(1, true);

				$dataRepo->create([
					'form_id' => $form->id,
					'field_id' => $field->id,
					'entry_id' => $entry->id,
					'user_id' => $userId,
					'value' => $value,
				]);
			}
		}
	}
}
