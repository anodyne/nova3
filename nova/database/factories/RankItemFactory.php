<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Models\States\Items\Active;
use Nova\Ranks\Models\States\Items\Inactive;

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
            'status' => Active::class,
        ];
    }

    public function inactive()
    {
        return $this->state([
            'status' => Inactive::class,
        ]);
    }
}
