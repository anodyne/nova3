<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Discussions\Enums\MessageType;
use Nova\Discussions\Models\Discussion;
use Nova\Discussions\Models\DiscussionMessage;
use Nova\Users\Models\User;

/** @extends Factory<DiscussionMessage> */
class DiscussionMessageFactory extends Factory
{
    protected $model = DiscussionMessage::class;

    public function definition(): array
    {
        return [
            'discussion_id' => Discussion::factory(),
            'user_id' => User::factory(),
            'content' => fake()->paragraph,
            'type' => fake()->randomElement(MessageType::cases()),
        ];
    }

    public function system(): static
    {
        return $this->state(fn (array $attributes): array => [
            'type' => MessageType::System,
        ]);
    }

    public function systemDanger(): static
    {
        return $this->state(fn (array $attributes): array => [
            'type' => MessageType::SystemDanger,
        ]);
    }

    public function text(): static
    {
        return $this->state(fn (array $attributes): array => [
            'type' => MessageType::Text,
        ]);
    }
}
