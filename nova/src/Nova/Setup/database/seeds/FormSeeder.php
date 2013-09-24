<?php

class FormSeeder extends Seeder {

	public function run()
	{
		$this->seedMissionIdeasForm();
	}

	protected function seedMissionIdeasForm()
	{
		// Create a new faker instance
		$faker = Faker\Factory::create();

		$form = FormModel::create([
			'key'					=> 'MissionIdeas',
			'name'					=> 'Mission Ideas',
			'form_viewer'			=> (int) true,
			'form_viewer_message'	=> $faker->paragraph(),
		]);

		$sections = [
			['name' => 'Basic Info', 'order' => 0, 'form_id' => $form->id],
			['name' => 'Detailed Info', 'order' => 1, 'form_id' => $form->id],
		];

		$sectionIds = [];

		foreach ($sections as $s)
		{
			$newSection = FormSectionModel::create($s);

			$sectionIds[] = $newSection->id;
		}

		$fields = [
			[
				'form_id'				=> $form->id,
				'section_id'			=> $sectionIds[0],
				'type'					=> 'text',
				'label'					=> 'Mission Title',
				'order'					=> 0,
			],
			[
				'form_id'				=> $form->id,
				'section_id'			=> $sectionIds[0],
				'type'					=> 'text',
				'label'					=> 'Start Date',
				'order'					=> 1,
			],
			[
				'form_id'				=> $form->id,
				'section_id'			=> $sectionIds[0],
				'type'					=> 'textarea',
				'label'					=> 'Summary',
				'order'					=> 2,
				'html_rows'				=> 3,
				'html_container_class'	=> 'col-lg-8',
			],
			[
				'form_id'				=> $form->id,
				'section_id'			=> $sectionIds[1],
				'type'					=> 'textarea',
				'label'					=> 'Act 1 Details',
				'order'					=> 0,
				'html_rows'				=> 3,
				'html_container_class'	=> 'col-lg-8',
			],
			[
				'form_id'				=> $form->id,
				'section_id'			=> $sectionIds[1],
				'type'					=> 'textarea',
				'label'					=> 'Act 2 Details',
				'order'					=> 1,
				'html_rows'				=> 3,
				'html_container_class'	=> 'col-lg-8',
			],
			[
				'form_id'				=> $form->id,
				'section_id'			=> $sectionIds[1],
				'type'					=> 'textarea',
				'label'					=> 'Act 3 Details',
				'order'					=> 2,
				'html_rows'				=> 3,
				'html_container_class'	=> 'col-lg-8',
			],
		];

		foreach ($fields as $f)
		{
			FormFieldModel::create($f);
		}
	}

}