<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Applications\Enums\ApplicationResult;
use Nova\Applications\Models\Application;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

class ApplicationFactory extends Factory
{
    protected $model = Application::class;

    public function definition()
    {
        return [
            'user_id' => User::factory()->pending(),
            'character_id' => Character::factory()->pending(),
            'ip_address' => $this->faker->ipv4(),
            'result' => ApplicationResult::Pending,
        ];
    }

    public function accepted()
    {
        return $this->state([
            'result' => ApplicationResult::Accept,
            'decision_date' => now(),
            'decision_message' => $this->faker->paragraphs(3, asText: true),
        ]);
    }

    public function denied()
    {
        return $this->state([
            'result' => ApplicationResult::Deny,
            'decision_date' => now(),
            'decision_message' => $this->faker->paragraphs(3, asText: true),
        ]);
    }
}
