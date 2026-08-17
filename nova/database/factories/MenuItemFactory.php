<?php

declare(strict_types=1);

namespace Database\Factories;

use Database\Factories\Concerns\CanHandleDataForRequests;
use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Menus\Enums\LinkTarget;
use Nova\Menus\Enums\LinkType;
use Nova\Menus\Models\MenuItem;

/** @extends Factory<MenuItem> */
class MenuItemFactory extends Factory
{
    use CanHandleDataForRequests;

    protected $model = MenuItem::class;

    public function active(): Factory
    {
        return $this->state([
            'status' => BasicStatus::Active,
        ]);
    }

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

    public function inactive(): Factory
    {
        return $this->state([
            'status' => BasicStatus::Inactive,
        ]);
    }
}
