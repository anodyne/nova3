<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\PostTypes\Data\Field;
use Nova\PostTypes\Data\Fields;
use Nova\PostTypes\Data\Options;
use Nova\PostTypes\Models\PostType;
use Nova\PostTypes\Models\States\Active;
use Nova\PostTypes\Models\States\Inactive;

class PostTypeFactory extends Factory
{
    protected $model = PostType::class;

    public function definition()
    {
        $word = $this->faker->word;

        return [
            'status' => Active::class,
            'description' => $this->faker->sentence,
            'key' => $this->faker->lexify("{$word}-????"),
            'name' => ucfirst($word),
            'visibility' => $this->faker->randomElement(['in-character', 'out-of-character']),
            'color' => $this->faker->hexColor,
            'icon' => 'book',
            'fields' => Fields::from([
                'title' => Field::from([
                    'enabled' => true,
                    'validate' => true,
                ]),
                'day' => Field::from([
                    'enabled' => true,
                    'validate' => true,
                ]),
                'time' => Field::from([
                    'enabled' => true,
                    'validate' => true,
                ]),
                'location' => Field::from([
                    'enabled' => true,
                    'validate' => true,
                ]),
                'content' => Field::from([
                    'enabled' => true,
                    'validate' => true,
                ]),
                'rating' => Field::from([
                    'enabled' => true,
                    'validate' => true,
                ]),
                'summary' => Field::from([
                    'enabled' => true,
                    'validate' => true,
                ]),
            ]),
            'options' => Options::from([
                'notifyUsers' => true,
                'notifyDiscord' => true,
                'includeInPostTracking' => true,
                'multipleAuthors' => true,
            ]),
        ];
    }

    public function inactive()
    {
        return $this->state([
            'status' => Inactive::class,
        ]);
    }
}
