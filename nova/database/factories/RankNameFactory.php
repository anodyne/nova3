<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Support\FactoryRequestData;
use Nova\Ranks\Models\RankName;

class RankNameFactory extends Factory
{
    protected $model = RankName::class;

    public function definition()
    {
        return [
            'name' => ucfirst($this->faker->words(3, asText: true)),
            'status' => BasicStatus::Active,
        ];
    }

    public function active()
    {
        return $this->state([
            'status' => BasicStatus::Active,
        ]);
    }

    public function inactive()
    {
        return $this->state([
            'status' => BasicStatus::Inactive,
        ]);
    }

    public function forRequest(): FactoryRequestData
    {
        $model = $this->make();

        $payload = [
            'name' => $model->name,
        ];

        if ($model->status === BasicStatus::Active) {
            $payload['status'] = 'true';
        }

        return FactoryRequestData::from(model: $model, payload: $payload);
    }
}
