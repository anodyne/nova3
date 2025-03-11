<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Ranks\Models\RankGroup;

class RankGroupFactory extends Factory
{
    protected $model = RankGroup::class;

    public function definition()
    {
        return [
            'name' => ucfirst($this->faker->words(3, asText: true)),
            'status' => BasicStatus::Active,
        ];
    }

    public function inactive()
    {
        return $this->state([
            'status' => BasicStatus::Inactive,
        ]);
    }
}
