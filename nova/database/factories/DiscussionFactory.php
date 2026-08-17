<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Discussions\Models\Discussion;

/** @extends Factory<Discussion> */
class DiscussionFactory extends Factory
{
    protected $model = Discussion::class;

    public function definition(): array
    {
        return [
            'discussable_type' => null,
            'discussable_id' => null,
            'subject' => null,
        ];
    }
}
