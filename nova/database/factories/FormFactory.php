<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Nova\Forms\Models\Form;

class FormFactory extends Factory
{
    protected $model = Form::class;

    public function definition()
    {
        $name = $this->faker->words(2, true);

        return [
            'key' => Str::slug($name),
            'name' => $name,
            'locked' => false,
        ];
    }

    public function locked()
    {
        return $this->state([
            'locked' => true,
        ]);
    }
}
