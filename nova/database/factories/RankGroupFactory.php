<?php

namespace Database\Factories;

use Nova\Ranks\Models\RankGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class RankGroupFactory extends Factory
{
    protected $model = RankGroup::class;

    public function definition()
    {
        return [
            'name' => ucfirst($this->faker->word),
        ];
    }
}
