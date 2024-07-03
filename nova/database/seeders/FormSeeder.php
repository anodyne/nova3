<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Forms\Data\FormOptions;
use Nova\Forms\Models\Form;

class FormSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        Form::factory()->basic()->create([
            'name' => 'Story Ideas',
            'key' => 'story-ideas',
            'options' => new FormOptions(
                onlyAuthenticatedUsers: true,
                collectResponses: true,
                singleSubmission: false,
                submissionTitleField: null,
                emailResponses: false
            ),
        ]);

        activity()->enableLogging();
    }
}
