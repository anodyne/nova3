<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormSubmission;
use Nova\Users\Models\User;

class FormSubmissionFactory extends Factory
{
    protected $model = FormSubmission::class;

    public function definition()
    {
        return [
            'form_id' => Form::factory(),
            'owner_id' => User::factory(),
            'owner_type' => function (array $attributes) {
                return User::find($attributes['owner_id'])->getMorphClass();
            },
        ];
    }
}
