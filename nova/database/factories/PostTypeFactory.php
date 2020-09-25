<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\PostTypes\DataTransferObjects\Field;
use Nova\PostTypes\DataTransferObjects\Fields;
use Nova\PostTypes\DataTransferObjects\Options;
use Nova\PostTypes\Models\PostType;

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
                'title' => new Field([
                    'enabled' => true,
                    'validate' => true,
                    'suggest' => true,
                ]),
                'day' => new Field([
                    'enabled' => true,
                    'validate' => true,
                    'suggest' => true,
                ]),
                'time' => new Field([
                    'enabled' => true,
                    'validate' => true,
                    'suggest' => true,
                ]),
                'location' => new Field([
                    'enabled' => true,
                    'validate' => true,
                    'suggest' => true,
                ]),
                'content' => new Field([
                    'enabled' => true,
                    'validate' => true,
                    'suggest' => true,
                ]),
                'rating' => new Field([
                    'enabled' => true,
                    'validate' => true,
                    'suggest' => true,
                ]),
            ]),
            'options' => new Options([
                'notifyUsers' => true,
                'notifyDiscord' => true,
                'includeInPostCounts' => true,
                'multipleAuthors' => true,
            ]),
        ];
    }
}
