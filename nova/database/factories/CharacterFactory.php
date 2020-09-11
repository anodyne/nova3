<?php

namespace Database\Factories;

use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Types\Primary;
use Nova\Characters\Models\States\Types\Support;
use Nova\Characters\Models\States\Statuses\Active;
use Nova\Characters\Models\States\Types\Secondary;
use Nova\Characters\Models\States\Statuses\Pending;
use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Characters\Models\States\Statuses\Inactive;

class CharacterFactory extends Factory
{
    protected $model = Character::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'type' => Support::class,
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
            'type' => Primary::class,
        ]);
    }

    public function secondary()
    {
        return $this->state([
            'type' => Secondary::class,
        ]);
    }

    public function support()
    {
        return $this->state([
            'type' => Support::class,
        ]);
    }
}
