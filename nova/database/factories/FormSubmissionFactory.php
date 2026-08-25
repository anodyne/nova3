<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormSubmission;
use Nova\Users\Models\User;

/** @extends Factory<FormSubmission> */
class FormSubmissionFactory extends Factory
{
    protected $model = FormSubmission::class;

    public function applicationInfo(): static
    {
        return $this->state([
            'form_id' => Form::key('applicationInfo')->first(),
        ]);
    }

    public function applicationReview(): static
    {
        return $this->state([
            'form_id' => Form::key('applicationReview')->first(),
        ]);
    }

    public function characterBio(): static
    {
        return $this->state([
            'form_id' => Form::key('characterBio')->first(),
        ]);
    }

    public function definition(): array
    {
        return [
            'form_id' => Form::factory(),
            'owner_id' => User::factory(),
            'owner_type' => (new User)->getMorphClass(),
        ];
    }

    public function userBio(): static
    {
        return $this->state([
            'form_id' => Form::key('userBio')->first(),
        ]);
    }
}
