<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Support\FactoryRequestData;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;

class RankItemFactory extends Factory
{
    protected $model = RankItem::class;

    public function definition()
    {
        return [
            'group_id' => fn () => RankGroup::factory(),
            'name_id' => fn () => RankName::factory(),
            'base_image' => 'base.png',
            'overlay_image' => 'overlay.png',
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
            'group_id' => $model->group_id,
            'name_id' => $model->name_id,
            'base_image' => $model->base_image,
            'overlay_image' => $model->overlay_image,
        ];

        if ($model->status === BasicStatus::Active) {
            $payload['status'] = 'true';
        }

        return FactoryRequestData::from(model: $model, payload: $payload);
    }
}
