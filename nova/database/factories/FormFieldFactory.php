<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormField;

class FormFieldFactory extends Factory
{
    protected $model = FormField::class;

    public function definition()
    {
        $name = fake()->words(3, asText: true);

        return [
            'form_id' => Form::factory(),
            'name' => $name,
            'uid' => Str::random(),
            'label' => ucfirst($name),
            'type' => str($name)->slug(),
        ];
    }
}
