<?php

namespace Database\Factories;

use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Models\RankGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        ];
    }
}
