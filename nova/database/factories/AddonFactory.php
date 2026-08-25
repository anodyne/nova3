<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Nova\Addons\Enums\AddonType;
use Nova\Addons\Models\Addon;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Support\FactoryRequestData;

/** @extends Factory<Addon> */
class AddonFactory extends Factory
{
    protected $model = Addon::class;

    public function active(): static
    {
        return $this->state([
            'status' => BasicStatus::Active,
        ]);
    }

    public function definition(): array
    {
        $name = rtrim($this->faker->sentence(mt_rand(2, 4), variableNbWords: false), '.');

        return [
            'name' => ucfirst($name),
            'location' => Str::studly($name),
            'version' => '1.0',
            'status' => BasicStatus::Active,
            'type' => $this->faker->randomElement(AddonType::cases()),
            'preview' => 'preview.jpg',
        ];
    }

    public function extension(): static
    {
        return $this->state([
            'type' => AddonType::Extension,
        ]);
    }

    public function forRequest(): FactoryRequestData
    {
        $model = $this->make();

        $payload = [
            'name' => $model->name,
            'location' => $model->location,
            'version' => $model->version,
            'type' => $model->type->value,
            'preview' => $model->preview,
        ];

        if ($model->status === BasicStatus::Active) {
            $payload['status'] = 'true';
        }

        return FactoryRequestData::from(model: $model, payload: $payload);
    }

    public function genre(): static
    {
        return $this->state([
            'type' => AddonType::Genre,
        ]);
    }

    public function inactive(): static
    {
        return $this->state([
            'status' => BasicStatus::Inactive,
        ]);
    }

    public function rank(): static
    {
        return $this->state([
            'type' => AddonType::Rank,
        ]);
    }
}
