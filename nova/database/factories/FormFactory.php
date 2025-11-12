<?php

declare(strict_types=1);

namespace Database\Factories;

use Database\Factories\Concerns\CanHandleDataForRequests;
use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Forms\Enums\FormType;
use Nova\Forms\Models\Form;
use Nova\Foundation\Enums\BasicStatus;

class FormFactory extends Factory
{
    use CanHandleDataForRequests;

    protected $model = Form::class;

    public function definition()
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

    public function active()
    {
        return $this->state([
            'status' => BasicStatus::Active,
        ]);
    }

    public function advanced()
    {
        return $this->state([
            'type' => FormType::Advanced,
        ]);
    }

    public function basic()
    {
        return $this->state([
            'type' => FormType::Basic,
        ]);
    }

    public function inactive()
    {
        return $this->state([
            'status' => BasicStatus::Inactive,
        ]);
    }

    public function locked()
    {
        return $this->state([
            'is_locked' => true,
        ]);
    }
}
