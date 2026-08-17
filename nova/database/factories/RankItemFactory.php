<?php

declare(strict_types=1);

namespace Database\Factories;

use Database\Factories\Concerns\CanHandleDataForRequests;
use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;

/** @extends Factory<RankItem> */
class RankItemFactory extends Factory
{
    use CanHandleDataForRequests;

    protected $model = RankItem::class;

    public function active()
    {
        return $this->state([
            'status' => BasicStatus::Active,
        ]);
    }

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

    public function inactive()
    {
        return $this->state([
            'status' => BasicStatus::Inactive,
        ]);
    }
}
