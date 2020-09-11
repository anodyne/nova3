<?php

namespace Database\Factories;

use Nova\Ranks\Models\RankName;
use Illuminate\Database\Eloquent\Factories\Factory;

class RankNameFactory extends Factory
{
    protected $model = RankName::class;

    public function definition()
    {
        return [
            'name' => ucfirst($this->faker->word),
        ];
    }
}
