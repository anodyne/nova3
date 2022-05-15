<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Models\States\Names\Active;
use Nova\Ranks\Models\States\Names\Inactive;

class RankNameFactory extends Factory
{
    protected $model = RankName::class;

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
