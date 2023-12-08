<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Stories\Data\Field;
use Nova\Stories\Data\Fields;
use Nova\Stories\Data\Options;
use Nova\Stories\Enums\PostTypeStatus;
use Nova\Stories\Models\PostType;

class PostTypeFactory extends Factory
{
    protected $model = PostType::class;

    public function definition()
    {
        $word = $this->faker->word;

        return [
            'status' => PostTypeStatus::active,
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
                'notifiesUsers' => true,
                'includedInPostTracking' => true,
                'allowsMultipleAuthors' => true,
                'allowsCharacterAuthors' => true,
                'allowedUserAuthors' => true,
                'showContentInTimelineView' => false,
                'editTimeframe' => '4h',
            ]),
        ];
    }

    public function inactive()
    {
        return $this->state([
            'status' => PostTypeStatus::inactive,
        ]);
    }
}
