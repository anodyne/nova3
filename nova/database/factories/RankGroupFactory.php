<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\States\Groups\Active;
use Nova\Ranks\Models\States\Groups\Inactive;

class RankGroupFactory extends Factory
{
    protected $model = RankGroup::class;

    public function definition()
    {
        return [
            'name' => ucfirst($this->faker->word),
            'status' => Active::class,
        ];
    }

    public function inactive()
    {
        return $this->state([
            'status' => Inactive::class,
        ]);
    }
}
