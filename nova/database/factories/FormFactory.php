<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Forms\Enums\FormType;
use Nova\Forms\Models\Form;

class FormFactory extends Factory
{
    protected $model = Form::class;

    public function definition()
    {
        $name = $this->faker->words(2, true);

        return [
            'key' => str($name)->slug()->value(),
            'name' => $name,
            'type' => FormType::Basic,
            'is_locked' => false,
        ];
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

    public function locked()
    {
        return $this->state([
            'is_locked' => true,
        ]);
    }
}
