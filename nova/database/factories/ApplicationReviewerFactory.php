<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Applications\Enums\ReviewerType;
use Nova\Applications\Models\ApplicationReviewer;
use Nova\Users\Models\User;

/** @extends Factory<ApplicationReviewer> */
class ApplicationReviewerFactory extends Factory
{
    protected $model = ApplicationReviewer::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'type' => ReviewerType::Global,
            'conditions' => null,
        ];
    }

    public function conditional(): static
    {
        return $this->state([
            'type' => ReviewerType::Conditional,
            'conditions' => [],
        ]);
    }

    public function global(): static
    {
        return $this->state([
            'type' => ReviewerType::Global,
            'conditions' => null,
        ]);
    }
}
