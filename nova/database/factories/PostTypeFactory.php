<?php

declare(strict_types=1);

namespace Database\Factories;

use Anodyne\TablerIcons\Tabler;
use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Stories\Data\Field;
use Nova\Stories\Data\Fields;
use Nova\Stories\Data\Options;
use Nova\Stories\Enums\PostEditTimeframe;
use Nova\Stories\Enums\PostTypeVisibility;
use Nova\Stories\Models\PostType;

/** @extends Factory<PostType> */
class PostTypeFactory extends Factory
{
    protected $model = PostType::class;

    public function active()
    {
        return $this->state([
            'status' => BasicStatus::Active,
        ]);
    }

    public function definition()
    {
        $word = $this->faker->word;

        return [
            'status' => BasicStatus::Active,
            'description' => $this->faker->sentence,
            'key' => $this->faker->lexify("{$word}-????"),
            'name' => ucfirst($word),
            'visibility' => $this->faker->randomElement(PostTypeVisibility::cases()),
            'color' => $this->faker->hexColor,
            'icon' => Tabler::Book,
            'fields' => Fields::from([
                'title' => Field::from(
                    enabled: true,
                    required: true,
                ),
                'day' => Field::from(
                    enabled: true,
                    required: true,
                ),
                'time' => Field::from(
                    enabled: true,
                    required: true,
                ),
                'location' => Field::from(
                    enabled: true,
                    required: true,
                ),
                'content' => Field::from(
                    enabled: true,
                    required: true,
                ),
                'rating' => Field::from(
                    enabled: true,
                    required: true,
                ),
                'summary' => Field::from(
                    enabled: true,
                    required: true,
                ),
            ]),
            'options' => Options::from(
                notifiesUsers: true,
                includedInPostTracking: true,
                allowsMultipleAuthors: true,
                allowsCharacterAuthors: true,
                allowsUserAuthors: true,
                showContentInTimelineView: false,
                editTimeframe: PostEditTimeframe::Hour4,
            ),
        ];
    }

    public function inactive()
    {
        return $this->state([
            'status' => BasicStatus::Inactive,
        ]);
    }
}
