<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Menus\Enums\LinkTarget;
use Nova\Menus\Enums\LinkType;
use Nova\Menus\Models\MenuItem;

class MenuItemFactory extends Factory
{
    protected $model = MenuItem::class;

    public function definition()
    {
        return [
            'label' => $this->faker->word(),
            'link_type' => $this->faker->randomElement(LinkType::cases()),
            'url' => $this->faker->url(),
            'page_id' => 1,
            'menu_id' => 1,
            'status' => BasicStatus::Active,
            'target' => $this->faker->randomElement(LinkTarget::cases()),
            'parent_id' => null,
        ];
    }
}
