<?php

declare(strict_types=1);

namespace Database\Factories;

use Database\Factories\Concerns\CanHandleDataForRequests;
use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Status\Active;
use Nova\Characters\Models\States\Status\Inactive;
use Nova\Characters\Models\States\Status\Pending;

class CharacterFactory extends Factory
{
    use CanHandleDataForRequests;

    protected $model = Character::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'type' => CharacterType::Support,
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
            'type' => CharacterType::Primary,
        ]);
    }

    public function secondary()
    {
        return $this->state([
            'type' => CharacterType::Secondary,
        ]);
    }

    public function support()
    {
        return $this->state([
            'type' => CharacterType::Support,
        ]);
    }

    public function trashed()
    {
        return $this->state([
            'deleted_at' => now(),
        ]);
    }
}
