<?php

declare(strict_types=1);

namespace Database\Factories;

use Database\Factories\Concerns\CanHandleDataForRequests;
use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Forms\Enums\FormType;
use Nova\Forms\Models\Form;
use Nova\Foundation\Enums\BasicStatus;

/** @extends Factory<Form> */
class FormFactory extends Factory
{
    use CanHandleDataForRequests;

    protected $model = Form::class;

    public function active(): static
    {
        return $this->state([
            'status' => BasicStatus::Active,
        ]);
    }

    public function advanced(): static
    {
        return $this->state([
            'type' => FormType::Advanced,
        ]);
    }

    public function basic(): static
    {
        return $this->state([
            'type' => FormType::Basic,
        ]);
    }

    public function definition(): array
    {
        $name = $this->faker->words(3, true);

        return [
            'key' => str($name)->slug()->value(),
            'name' => $name,
            'type' => FormType::Basic,
            'is_locked' => false,
            'status' => BasicStatus::Active,
            'options' => null,
        ];
    }

    public function inactive(): static
    {
        return $this->state([
            'status' => BasicStatus::Inactive,
        ]);
    }

    public function locked(): static
    {
        return $this->state([
            'is_locked' => true,
        ]);
    }
}
