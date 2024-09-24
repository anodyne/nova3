<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Discussions\Enums\MessageType;
use Nova\Discussions\Models\Discussion;
use Nova\Discussions\Models\DiscussionMessage;
use Nova\Users\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Nova\Model>
 */
class DiscussionMessageFactory extends Factory
{
    protected $model = DiscussionMessage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'discussion_id' => Discussion::factory(),
            'user_id' => User::factory(),
            'content' => fake()->paragraph,
            'type' => fake()->randomElement(MessageType::cases()),
        ];
    }

    public function system()
    {
        return $this->state(fn (array $attributes) => [
            'type' => MessageType::System,
        ]);
    }

    public function systemDanger()
    {
        return $this->state(fn (array $attributes) => [
            'type' => MessageType::SystemDanger,
        ]);
    }

    public function text()
    {
        return $this->state(fn (array $attributes) => [
            'type' => MessageType::Text,
        ]);
    }
}
