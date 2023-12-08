<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Ranks\Enums\RankNameStatus;
use Nova\Ranks\Models\RankName;

class RankNameFactory extends Factory
{
    protected $model = RankName::class;

    public function definition()
    {
        return [
            'name' => ucfirst($this->faker->words(3, asText: true)),
            'status' => RankNameStatus::active,
        ];
    }

    public function inactive()
    {
        return $this->state([
            'status' => RankNameStatus::inactive,
        ]);
    }
}
