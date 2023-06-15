<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Statuses\Active;
use Nova\Characters\Models\States\Statuses\Inactive;
use Nova\Characters\Models\States\Statuses\Pending;

class CharacterFactory extends Factory
{
    protected $model = Character::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'type' => CharacterType::support,
            'status' => Active::class,
        ];
    }

    public function active()
    {
        return $this->state([
            'status' => Active::class,
        ]);
    }

    public function inactive()
    {
        return $this->state([
            'status' => Inactive::class,
        ]);
    }

    public function pending()
    {
        return $this->state([
            'status' => Pending::class,
        ]);
    }

    public function primary()
    {
        return $this->state([
            'type' => CharacterType::primary,
        ]);
    }

    public function secondary()
    {
        return $this->state([
            'type' => CharacterType::secondary,
        ]);
    }

    public function support()
    {
        return $this->state([
            'type' => CharacterType::support,
        ]);
    }
}
