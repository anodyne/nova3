<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Discussions\Models\Discussion;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Nova\Model>
 */
class DiscussionFactory extends Factory
{
    protected $model = Discussion::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'discussable_type' => null,
            'discussable_id' => null,
            'name' => null,
        ];
    }
}
