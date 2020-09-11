<?php

namespace Database\Factories;

use Nova\PostTypes\Models\PostType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\PostTypes\DataTransferObjects\Fields;
use Nova\PostTypes\DataTransferObjects\Options;

class PostTypeFactory extends Factory
{
    protected $model = PostType::class;

    public function definition()
    {
        $word = $this->faker->word;

        return [
            'active' => $this->faker->randomElement([true, false]),
            'description' => $this->faker->sentence,
            'key' => $this->faker->lexify("{$word}-????"),
            'name' => ucfirst($word),
            'visibility' => $this->faker->randomElement(['in-character', 'out-of-character']),
            'color' => $this->faker->hexColor,
            'icon' => 'book',
            'fields' => new Fields([
                'title' => true,
                'day' => false,
                'time' => false,
                'location' => true,
                'content' => false,
            ]),
            'options' => new Options([
                'notifyUsers' => true,
                'notifyDiscord' => true,
                'includeInPostCounts' => false,
                'multipleAuthors' => true,
            ]),
        ];
    }
}
