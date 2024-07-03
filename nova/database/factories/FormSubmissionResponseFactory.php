<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Nova\Forms\Models\FormSubmission;
use Nova\Forms\Models\FormSubmissionResponse;

class FormSubmissionResponseFactory extends Factory
{
    protected $model = FormSubmissionResponse::class;

    public function definition()
    {
        $name = $this->faker->words(2, true);

        return [
            'submission_id' => FormSubmission::factory(),
            'field_type' => $name,
            'field_uid' => Str::random(),
            'value' => '',
        ];
    }
}
