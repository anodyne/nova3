<?php

declare(strict_types=1);

namespace Database\Factories;

use Database\Factories\Concerns\CanHandleDataForRequests;
use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Ranks\Models\RankGroup;

/** @extends Factory<RankGroup> */
class RankGroupFactory extends Factory
{
    use CanHandleDataForRequests;

    protected $model = RankGroup::class;

    public function active()
    {
        return $this->state([
            'status' => BasicStatus::Active,
        ]);
    }

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
