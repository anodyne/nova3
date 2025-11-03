<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Applications\Enums\ReviewerType;
use Nova\Applications\Models\ApplicationReviewer;
use Nova\Users\Models\User;

class ApplicationReviewerFactory extends Factory
{
    protected $model = ApplicationReviewer::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'type' => ReviewerType::Global,
            'conditions' => null,
        ];
    }

    public function global()
    {
        return $this->state([
            'type' => ReviewerType::Global,
            'conditions' => null,
        ]);
    }

    public function conditional()
    {
        return $this->state([
            'type' => ReviewerType::Conditional,
            'conditions' => [],
        ]);
    }
}
